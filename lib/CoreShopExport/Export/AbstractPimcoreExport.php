<?php

namespace CoreShopExport\Export;

use Pimcore\Model\Object\AbstractObject;
use Pimcore\Model\Object\Concrete;
use Pimcore\Model\Webservice\Data\Object\Element;

abstract class AbstractPimcoreExport implements ExportInterface
{
    /**
     * @param $class
     * @param array $config
     * @param array $nameMap
     * @param array $skip
     * @param array $convert
     * @return array
     */
    public function export($class, array $config = [], array $nameMap = [], array $skip = [], array $convert = [])
    {
        $data = [];
        $objects = $class::getList($config)->getObjects();

        if (count($objects) > 0) {
            foreach ($objects as $object) {
                $data[$object->getId()] = $this->exportObject($object, $nameMap, $skip, $convert);
            }
        }

        return $data;
    }

    /**
     * @param AbstractObject $object
     * @param array $nameMap
     * @param array $skip
     * @param array $convert
     * @return array
     */
    protected function exportObject(AbstractObject $object, $nameMap = [], $skip = [], $convert = []) {
        $elements = array();
        $objectSystemColumnsNames = array("id", "fullpath", "published", "key", "classname");

        $typeMap = [
            'coreShopShopMultiselect' => 'coreShopStoreMultiselect'
        ];

        if($object instanceof Concrete) {
            $fd = $object->getClass()->getFieldDefinitions();

            foreach ($fd as $field) {
                $getter = "get" . ucfirst($field->getName());

                if (method_exists($object, $getter)) {
                    $originalFieldName = $field->getName();

                    $fieldType = $field->getFieldType();
                    $fieldName = $field->getName();

                    if (array_key_exists($fieldType, $typeMap)) {
                        $fieldType = $typeMap[$fieldType];
                    }

                    if (array_key_exists($fieldName, $nameMap)) {
                        $fieldName = $nameMap[$fieldName];
                    }

                    if (in_array($fieldName, $skip)) {
                        continue;
                    }

                    if (array_key_exists($fieldName, $convert)) {
                        $fieldType = $convert[$fieldName]['type'];
                        $fieldName = $convert[$fieldName]['name'];
                    }

                    $el = new Element();
                    $el->name = $fieldName;
                    $el->type = $fieldType;

                    $el->value = $field->getForWebserviceExport($object);

                    if (array_key_exists($originalFieldName, $convert)) {
                        if (array_key_exists('transform', $convert[$originalFieldName])) {
                            $el->value = $convert[$originalFieldName]['transform']($el->value);
                        }
                    }

                    $elements[] = $el;
                }
            }
        }

        $exportData = array(
            "elements" => $elements,
            "classname" => get_class($object),
            "path" => $object->getPath()
        );

        foreach($objectSystemColumnsNames  as $systemColumn) {
            $getter = "get" . ucfirst($systemColumn);

            if(method_exists($object, $getter)) {
                if($systemColumn === "classname") {
                    $exportData[$systemColumn] = "\\Pimcore\\Model\\Object\\" . $object->$getter();
                }
                else {
                    $exportData[$systemColumn] = $object->$getter();
                }
            }
        }

        return $exportData;
    }
}