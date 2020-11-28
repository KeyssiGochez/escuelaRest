<?php 
namespace App\Controllers\API;
use App\Models\EstudianteModel;
use CodeIgniter\RESTful\ResourceController;

class Estudiantes extends ResourceController
{
    public function __construct(){
        $this->model = $this->setModel(new EstudianteModel());
    }
	public function index()
	{
		$Estudiantes = $this->model->findAll();

		return $this->respond($Estudiantes);
	}
	public function create()
	{
		try {
            $Estudiantes = $this->request->getJSON();
            
            if($this->model->insert($Estudiantes)):
                
				$Estudiantes->id = $this->model->insertID();
				return $this->respondCreated($Estudiantes);
			else:
				return $this->failValidationError($this->model->validation->listErrors());
			endif;

		} catch (\Exception $e) {

			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
	public function edit($id = null)
	{
		try {
			if($id==null)
				return $this->failValidationError('No se ha pasado id valido');
			$Estudiantes = $this->model->find($id);

			if($Estudiantes==null)
				return $this->failNotFound('No hay ningun Estudiante con id: ' .$id);
			
			return $this->respond($Estudiantes);

		} catch (\Exception $e) {

			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
	public function update($id = null)
	{
		try {
			if($id==null)
                return $this->failValidationError('No se ha pasado id valido');
			$verificarestudiante = $this->model->find($id);

			if($verificarestudiante==null)
				return $this->failNotFound('No se ha encontrado ningun estudiante con id: ' .$id);
			
			$Estudiantes = $this->request->getJSON();
			if($this->model->update($id,$Estudiantes)):
				$Estudiantes->id= $id;
				return $this->respondUpdated($Estudiantes);
			else:
				return $this->failValidationError($this->model->validation->listErrors());
			endif;

		} catch (\Exception $e) {

			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
	public function delete($id = null)
	{

            try {
                if($id==null)
                    return $this->failValidationError('No se ha pasado id valido');
                $verificarestudiante = $this->model->find($id);
    
                if($verificarestudiante==null)
                    return $this->failNotFound('No se ha encontrado ningun estudiante con id: ' .$id);
                
			if($this->model->delete($id)):
				return $this->respondDeleted($verificarestudiante);
			else:
				return $this->failServerError('No se ha podido borrar el registro');
			endif;

		} catch (\Exception $e) {
			//throw $th;
			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
}
