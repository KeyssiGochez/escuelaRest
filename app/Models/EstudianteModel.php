<?php 

namespace App\Models;
use CodeIgniter\Model;

class EstudianteModel extends Model 
{
    protected $table            =   'estudiante';
    protected $primaryKey       =   'id';
    
    protected $allowedFields    =  ['nombre', 'apellido', 'dui', 'genero' 'grado_id'];

    protected $useTimestamps    = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules  = [
        'nombre'                => 'required|alpha_numeric_space|min_length[3]|max_length[60]',
        'apellido'              => 'required|alpha_numeric_space|min_length[1]|max_length[2]',
        'dui'                   => 'required|alpha_numeric_space|min_length[1]|max_length[2]',
        'genero'                => 'required|alpha_numeric_space|min_length[1]|max_length[2]',
        'carnet'                => 'required|regex_match[/^(u|U)20[1|2]{1}[0-9]{5}+$/]',
        'grado_id'              => 'required|integer|is_valid_grado',
    ];
    protected $validationMessages = [
        'grado_id' => ['is_valid_grado' => 'El grado que intenta ingresar no existe.']
    ];

    protected $skipValidation = false;
}