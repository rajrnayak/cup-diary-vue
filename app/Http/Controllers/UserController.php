<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index () : Response
    {
        return Inertia::render('user/Index');
    }

    function loadData(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $sortingColumns = $request->sorting_columns;
            $searchRows = $request->search_fields;

            $users = User::query()
            ->select(
                'id',
                'username',
                'first_name',
                'last_name',
                'mobile_number',
                'email',
            )
            ->when($searchRows, function (Builder $query, array $searchRows) {
                foreach ($searchRows as $key => $value) {
                    $query->orWhere($value['name'] , 'LIKE' , "%".$value['text']."%");
                }
            })
            ->when($sortingColumns, function (Builder $query, array $sortingColumns) {
                foreach ($sortingColumns as $key => $value) {
                    $query->orderBy($key, $value);
                }
            })
            ->paginate(perPage: $request->per_page_number, page: $request->page_number);

            // dd($users->toArray());

            DB::commit();
            return response()->json($users);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    function storeOrUpdate(UserFormRequest $request, User $user): JsonResponse
    {
        try {
            DB::beginTransaction();
            // $action = is_null($user->id) ? 'Created' : 'Updated';
            // store the user data in users table
            $fields = [
                'username' => $request->username,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'mobile_number' => $request->mobile_number,
                'email' => $request->email,
            ];

            $user->fill($fields)->save();

            DB::commit();

            return response()->json([
                'message' => "successfully.",
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    function destroy(User $user): JsonResponse
    {
        try {
            DB::beginTransaction();

            // delete user records
            $user->delete();

            DB::commit();

            return response()->json([
                'message' => "User - {$user->username} has been Deleted successfully.",
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
