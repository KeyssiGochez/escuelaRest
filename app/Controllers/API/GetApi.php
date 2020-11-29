<?php 
namespace App\Controllers\API;
use App\Models\GradoModel;
use CodeIgniter\RESTful\ResourceController;

class GetApi extends ResourceController
{
    public function __construct(){
        $this->model = $this->setModel(new GradoModel());
    }
	public function all($id = null)
	{
        $pModel = new \App\Models\ProfesorModel();
        $eModel = new \App\Models\EstudianteModel();

		try {
			if($id==null)
				return $this->failValidationError('No se ha pasado id valido');
			$grados = $this->model->find($id);

			if($grados==null)
                return $this->failNotFound('No hay ningun grado con id: ' .$id);
            
            $idp = $grados['profesor_id'];
			$grados = $this->model->select('grado,seccion')->find($id);
			$grados['profesor']=$pModel->where('id', $idp)->select(['CONCAT(nombre," ", apellido) as nombre', 'profesion','telefono'])->first();
                
            $grados['Alumnos'] = $eModel->where('grado_id', $id)->select('CONCAT(nombre," ", apellido) as nombre,genero, carnet')->findAll();
            
			if($grados != null):
				return $this->respond(
                    
                );
			else:
				return failValidationError($grados->validation->listErrors());
			endif;

		} catch (\Exception $e) {
			return failServerError('Ha ocurrido un error en el servidor');
		}
	}
}