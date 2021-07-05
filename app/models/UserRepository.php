<?php


namespace App\Model;


use App\Core\Database\EloquentDriver;
use App\Core\Request;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

/**
 * Class UserRepository
 * @package App\Model
 * @author Aufrère Guillian
 * @version 1.0
 */
class UserRepository
{
    private EloquentDriver $db;

    private Request $request;

    public function __construct(EloquentDriver $database, Request $request)
    {
        $this->db = $database;
        $this->request = $request;
    }

    /**
     * Get columns names for a table.
     *
     * @param string $table
     * @param array $filters
     *
     * @return array
     */
    private function getReferencesWithoutColumns(string $table, array $filters)
    {
        $reference = $this->db->getConnection()
            ->table($table)
            ->first()
        ;

        $reference = (array) $reference;

        foreach ($filters as $filter) {
            unset($reference[$filter]);
        }

        return array_keys($reference);
    }

    /**
     * Find one user by a column and a value.
     *
     * @param array $valueFilter A column to filter one.
     * @param array $columnsFilters Columns to remove from results.
     *
     * @return Model|Builder|object|null
     *
     * @throws Exception
     */
    public function findOneBy(array $valueFilter, array $columnsFilters = [])
    {
        if (count($valueFilter) != 2) {
            throw new Exception('Filters should be specified.');
        }

        $queryBuilder = $this->db->getConnection()->table('users');

        if (!empty($columnsFilters)) { // If we don't wan specifics columns.
            $columns = $this->getReferencesWithoutColumns('users', $columnsFilters);
            $queryBuilder->select($columns);
        }

        return $queryBuilder
            ->where($valueFilter[0], '=', $valueFilter[1])
            ->first()
        ;
    }

    /**
     * Find all users.
     *
     * @param array $filters A column to filter one.
     *
     * @return Collection
     */
    public function findAllWithout(array $filters = [])
    {
       
        $users =  User::with(['roles'])
            ->get()
        ;
        
        $users = $users
            ->makeVisible(['id'])
            ->makeHidden($filters)
        ;
            
        return $users;
        
        /* OLD REQUEST WITHOUT ROLES 
        
        
        $qb = $this->db->getConnection()->table('users');

        if (!empty($filters)) {
            $columns = $this->getReferencesWithoutColumns('users', $filters);
            $qb->select($columns);
        }

        return $qb->get();*/


    }

    /**
     * Find one user by usernames: identifier, mail pro, mail self.
     *
     * @param $username
     *
     * @return Model|Builder|object|null
     *
     * @throws Exception
     */
    public function findOneByUsernames($username)
    {
        $app = App::where('name', '=', $this->request->query()->get('issuer'))->first();

        // TODO: Mettre un LIKE pour les mails

        return User::where('identifier', '=', $username)
            ->orWhere('mailPro', '=', $username)
            ->orWhere('mailPerso', '=', $username)
            ->with(['roles' => function ($query) use ($app) {
                $query->where('app_id', $app->id);
            }])
            ->with('career')
            ->with('session')
            ->with('center')
            ->with('apps')
            ->with('financial')
            ->first()
        ;
    }

}
