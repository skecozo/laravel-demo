<?php

namespace App\Repositories;

trait BaseRepository
{

    public function all()
    {
        return $this->model->get();
    }
    /**
     * @param $input
     * @return mixed
     */
    public function store(array $input)
    {
        return $this->model->create($input);
    }

    public function getbyIds($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($id, $input)
    {
        $this->model = $this->getbyIds($id);

        return $this->save($this->model, $input);
    }

    public function save($model, $input)
    {
        $model->fill($input);

        $model->save($input);

        return $model;
    }

    public function destroy($id)
    {
        return $this->getbyIds($id)->delete();
    }

}
