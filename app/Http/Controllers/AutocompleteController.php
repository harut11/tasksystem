<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AutocompleteController extends Controller
{
    /**
     * Search user from database according to search term
     */
    public function searchUser(Request $request)
    {
        $term = $request['val'];
        $finded_users = [];

        if (isset($term) && strlen($term) > 1) {

            $users = User::where('first_name', 'LIKE', '%' . $term .'%')
                ->where('role', 'developer')->get();

            foreach ($users as $user) {
                $finded_users[] = $user;
            }

            echo json_encode(['users' => $finded_users]);
        }
    }
}
