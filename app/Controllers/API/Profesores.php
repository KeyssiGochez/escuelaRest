<?php 
namespace App\Controllers\API;
use App\Models\ProfesorModel;
use CodeIgniter\RESTful\ResourceController;

class Profesores extends ResourceController
{
    public function __construct(){
        $this->model = $this->setModel(new ProfesorModel());
    }
	public function index()
	{
		$profesores = $this->model->findAll();

		return $this->respond($profesores);
	}
	public function create()
	{
		try {
            $profesor = $this->request->getJSON();
            
            if($this->model->insert($profesor)):
                
				$profesor->id = $this->model->insertID();
				return $this->respondCreated($profesor);
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
			$profesor = $this->model->find($id);

			if($profesor==null)
				return $this->failNotFound('No hay un profesor con id: ' .$id);
			
			return $this->respond($profesor);

		} catch (\Exception $e) {

			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
	public function update($id = null)
	{
		try {
			if($id==null)
                return $this->failValidationError('No se ha pasado id valido');
			$verificarprofesor = $this->model->find($id);

			if($verificarprofesor==null)
				return $this->failNotFound('No se ha encontrado un profesor con id: ' .$id);
			
			$profesor = $this->request->getJSON();
			if($this->model->update($id,$profesor)):
				$profesor->id= $id;
				return $this->respondUpdated($profesor);
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
                $verificarprofesor = $this->model->find($id);
    
                if($verificarprofesor==null)
                    return $this->failNotFound('No se ha encontrado un profesor con id: ' .$id);
                
			if($this->model->delete($id)):
				return $this->respondDeleted($verificarprofesor);
			else:
				return $this->failServerError('No se ha podido borrar el registro');
			endif;

		} catch (\Exception $e) {
			//throw $th;
			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
}
