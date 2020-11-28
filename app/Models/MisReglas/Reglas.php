<?php 
namespace App\Models\MisReglas;
use App\Models\ProfesorModel;
use App\Models\GradoModel;

class Reglas {

public function is_valid_profesor(int $id): bool{
    $model = new ProfesorModel();
    $profesor = $model->find($id);  
    return $profesor == null ? false : true;
}
public function is_valid_grado(int $id): bool{
    $model = new GradoModel();
    $grado = $model->find($id);  
    return $grado == null ? false : true;
}

}