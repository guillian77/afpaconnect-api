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
    public function upload(Response $response)
    {
        if (!isset($_FILES["fileToUpload"]['type'])) {
            $response
                ->setStatusCode(400)
                ->setStatusMessage("Une erreur à lieu lors de l'upload du fichier.")
                ->send('400',true);
        }

        $isXLS = $_FILES["fileToUpload"]['type'] === Upload::FILE_TYPE_XML || $_FILES["fileToUpload"]['type'] === Upload::FILE_TYPE_EXCEL;

        $file_name = $_FILES["fileToUpload"]["name"];

        $ext_name = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if ($ext_name !== "xlsx") {
            $response
                ->setStatusCode(400)
                ->setStatusMessage("Erreur: seuls les fichiers au format .xlsx sont acceptés.")
                ->send('400',true);
        }

        if (!$isXLS) {
            $response
                ->setStatusCode(400)
                ->setStatusMessage("Le fichier n'est pas un tableur excel ou XML")
                ->send('400',true);
        }

        $tmp_name = $_FILES["fileToUpload"]["tmp_name"];
        $content = Upload::parse($tmp_name);

        $response
            ->setBodyContent($content)
            ->setJsonFlags(JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE)
            ->send(200);
    }

    /**
     * Add users from XLSX file to database.
     */
    public function add(Response $response)
    {

        $users = json_decode($this->request->request(false)->get('uploaded_user'));

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
                $response
                    ->setStatusMessage("Erreur: Impossible d'ajouter l'utilisateur " . $user->prenom . " " . $user->nom_usuel . " dans la base de données. Arrêt de l'import, 
                    veuillez vérifier le format du tableau XLSX ou que le matricule n'est pas déjà existant.")
                    ->send('400',true);
            }
        }
        $response
            ->setStatusMessage("Tous les utilisateurs ont été ajouté avec succès.")
            ->send('200',true);
    }
}
