<?php 
namespace App\Controllers\API;
use App\Models\GradoModel;
use CodeIgniter\RESTful\ResourceController;

class grados extends ResourceController
{
    public function __construct(){
        $this->model = $this->setModel(new GradoModel());
    }
	public function index()
	{
		$grados = $this->model->findAll();

		return $this->respond($grados);
	}
	public function create()
	{
		try {
            $grados = $this->request->getJSON();
            
            if($this->model->insert($grados)):
                
				$grados->id = $this->model->insertID();
				return $this->respondCreated($grados);
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
			$grados = $this->model->find($id);

			if($grados==null)
				return $this->failNotFound('No hay ningun grado con id: ' .$id);
			
			return $this->respond($grados);

		} catch (\Exception $e) {

			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
	public function update($id = null)
	{
		try {
			if($id==null)
                return $this->failValidationError('No se ha pasado id valido');
			$verificargrado = $this->model->find($id);

			if($verificargrado==null)
				return $this->failNotFound('No se ha encontrado ningun grado con id: ' .$id);
			
			$grados = $this->request->getJSON();
			if($this->model->update($id,$grados)):
				$grados->id= $id;
				return $this->respondUpdated($grados);
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
                $verificargrado = $this->model->find($id);
    
                if($verificargrado==null)
                    return $this->failNotFound('No se ha encontrado ningun grado con id: ' .$id);
                
			if($this->model->delete($id)):
				return $this->respondDeleted($verificargrado);
			else:
				return $this->failServerError('No se ha podido borrar el registro');
			endif;

		} catch (\Exception $e) {
			//throw $th;
			return $this->failServerError('Ha ocurrido un error en el servidor');
		}
	}
}
