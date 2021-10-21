<?php


namespace App\Controller;

use App\Core\Request;
use App\Model\Financial;
use App\Model\Formation;
use App\Model\Session;
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
        try {

            $formation = Formation::whereId($this->request->request()->get('formation'))->first();

            if (is_null($formation)) {
                $formation = Formation::create(
                    [
                        'name' => $this->request->request()->get('formation'),
                        'tag'=> $this->request->request()->get('formation_tag'),
                    ]
                );
            }

            foreach ($users as $user) {
                $explodedDateStart = explode('/',$user->date_de_debut_resa);
                $session = Session::updateOrCreate(
                    ['n_offer' => $user->n_offre],
                    [
                        'name' => "Session-".$explodedDateStart[1]."-".$explodedDateStart[2],
                        'formation_id'=> $formation->id,
                        'n_offer'=> $user->n_offre,
                        'label_offer'=> $user->libelle_de_offre,
                        'start_at'=> $this->formatDate($user->date_de_debut_resa),
                        'end_at'=> $this->formatDate($user->date_de_fin_resa)
                    ]
                );

                $explodedFinancial = explode('-', $user->remuneration,2);

                $financial = Financial::updateOrCreate(
                    ['tag' => $explodedFinancial[0]],
                    [
                        'tag' => $explodedFinancial[0],
                        'name' => $explodedFinancial[1],
                        'public_name'=> $explodedFinancial[1],
                    ]);

                $actualUser = User::updateOrCreate(
                    ['identifier' => $user->n_client_stagiaire],
                    [
                        'firstname' => $user->prenom,
                        'lastname' => $user->nom_usuel,
                        'mail1' => $user->email,
                        'phone' => $user->telephone_1,
                        'address' => $user->adresse,
                        'measure' => $user->mesure,
                        'convention' => $user->convention,
                        'center_id' => $this->request->request()->get('center'),
                        'financial_id' => $financial->id,
                    ]
                );

                $actualUserSession = $actualUser->session()->get()->toArray();

                $isNewSession = true;
                array_walk($actualUserSession,function ($el) use ($session, &$isNewSession) {
                    if ($el['id'] === $session->id) $isNewSession = false;
                });

                $isNewSession && $actualUser->session()->attach($session->id);
                $actualUser->saveOrFail();

            }
        } catch (Exception $e) {
            $response
                ->setStatusMessage("Erreur: Le téléversement a échoué veuillez vérifier le format du fichier XLSX")
                ->send('400',true);
        }
        $response
            ->setStatusMessage("Tous les utilisateurs ont été ajouté avec succès.")
            ->send('200',true);
    }

    public function formatDate($date): string
    {
        $formattedDateStart = explode('/',$date);
        return $formattedDateStart[2].'-'.$formattedDateStart[1].'-'.$formattedDateStart[0];
    }
}
