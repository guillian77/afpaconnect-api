<?php


namespace App\Controller;

use App\Core\Request;
use App\Model\Financial;
use App\Model\User;
use App\Model\UserRepository;
use App\Utility\Response;
use App\Utility\Upload;
use Exception;

class UserUploadController extends Controller
{


    private Request $request;
    private UserRepository $userRepository;

    public function __construct(Request $request, UserRepository $userRepository, User $user)
    {
        $this->userRepository = $userRepository;
        $this->request = $request;
        $this->user = $user;
    }

    public function index(): void
    {
        $this->render('user/upload.html.twig');
    }

    /**
     * Return data from XLSX file
     */
    public function upload()
    {

        if (isset($_FILES["fileToUpload"]['type'])) {

            $isXLS = $_FILES["fileToUpload"]['type'] === "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                || $_FILES["fileToUpload"]['type'] === "application/vnd.ms-excel";

            $file_name = $_FILES["fileToUpload"]["name"];

            $check_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
           
            if ($check_ext == "xlsx") {
                if ($isXLS) {
                    $tmp_name = $_FILES["fileToUpload"]["tmp_name"];
                    $content = Upload::parse($tmp_name);
                    echo json_encode($content, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
                }
            } else {
                Response::resp("Erreur: seuls les fichiers au format .xlsx sont acceptés.", 400);
            }
        }
    }

    /**
     * Add users from XLSX file to database.
     */
    public function add()
    {

        $users = json_decode(htmlspecialchars_decode($this->request->request()->get('uploaded_user')));

        foreach ($users as $user) {
            // Check if user insertion work
            $newUser = new User();
            $newUser->firstname = $user->prenom;
            $newUser->lastname = $user->nom_usuel;
            $newUser->identifier = $user->beneficiaire;
            $newUser->financial_id  = Financial::whereTag($user->financeur)->first()->id;

            $newUser->center_id = $this->request->request()->get('center');

            try {
                $newUser->saveOrFail();
            } catch (Exception $e) {
                Response::resp("Erreur: Impossible d'ajouter l'utilisateur " . $user->prenom . " " . $user->nom_usuel . " dans la base de données. Arrêt de l'import, veuillez vérifier le format du tableau XLSX ou que le matricule n'est pas déjà existant.", 400);
                return;
            }
        }

        Response::resp("Tous les utilisateurs ont été ajouté avec succès.", 200);
    }
}
