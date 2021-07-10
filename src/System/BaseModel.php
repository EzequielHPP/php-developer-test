<?php

namespace App\System;

use App\System\Exception\ModelFileNotFound;

class BaseModel
{
    protected string $model;
    protected string $modelPath;

    /**
     * BaseModel constructor.
     *
     * This sets the model path for the json file
     */
    public function __construct()
    {
        $file = strtolower($this->model) . '.json';
        $fullPath = $_SERVER['DB_DIR'] . $file;
        $this->modelPath = $fullPath;
    }

    /**
     * Get all entries. If where is set then return matching ones
     *
     * @return array|mixed|null
     * @throws ModelFileNotFound
     */
    public function get()
    {
        $modelPath = $this->getModelPath();
        $output = [];
        foreach ($this->fetchAllData() as $entry) {
            $output[] = (new $modelPath($this->modelPath))->convertEntryToModel($entry);
        }
        return $output;
    }

    /**
     * Return the model path based on the name space and model variables
     *
     * @return string
     */
    private function getModelPath()
    {
        return $this->nameSpace . '\\' . substr($this->model, 0, -1);
    }

    /**
     * Get data from json file
     *
     * @return mixed
     * @throws ModelFileNotFound
     */
    private function fetchAllData()
    {
        if (!file_exists($this->modelPath)) {
            throw new ModelFileNotFound($this->model);
        }
        $content = file_get_contents($this->modelPath);
        return json_decode($content);
    }

    /**
     * Return specific entry from the DB
     * @param int $id
     * @return ?null
     * @throws ModelFileNotFound
     */
    public function find(int $id)
    {
        $data = $this->fetchAllData();
        $model = $this->getModelPath();
        $key = array_search((string)$id, array_column($data, 'id'), true);

        return $key === false ? null : (new $model())->convertEntryToModel($data[$key]);
    }

    /**
     * After getting the data from the json, populate this model with the fields from the object
     *
     * @param \StdClass $entry
     * @return $this
     */
    public function convertEntryToModel(\StdClass $entry): BaseModel
    {
        $properties = get_object_vars($entry);
        foreach ($properties as $property => $value) {
            $this->$property = $value;
        }
        return $this;
    }
}
