<?php


namespace Costa\User\Services;


use Costa\Package\Exceptions\CustomException;
use Costa\User\Repositories\Contracts\UserContract;
use Costa\User\Repositories\UserRepository;
use App\Tables\UserTable;
use ErrorException;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Okipa\LaravelTable\Table;

class UserService implements Contracts\UserContract
{

    private UserContract $userContract;
    private Request $request;

    /**
     * UserService constructor.
     * @param UserContract $userContract
     * @param Request $request
     */
    public function __construct(UserContract $userContract, Request $request)
    {
        /**
         * @var $userContract UserRepository
         */
        $this->userContract = $userContract;
        $this->request = $request;
    }

    /**
     * @return Table
     * @throws ErrorException
     */
    public function all(): Table
    {
        return (new UserTable())->setup();
    }

    /**
     * @param $id
     * @return UserContract|UserRepository|Model|null
     */
    public function show($id){
        return $this->userContract->getByColumn($id, config('costa_user.router.user'));
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->userContract->create(
            $data + ['password' => Hash::make($this->request->input('password'))]
        );
    }

    /**
     * @param $id
     * @param $data
     * @return Collection|Model
     */
    public function update($id, $data)
    {
        $objUser = $this->show($id);
        if(!empty($data['password_updated'])
            && auth()->user()
            && in_array(auth()->user()->email, config('costa_user.permissions.email_reset_password'))
        ){
            $data['password'] = Hash::make($data['password_updated']);
        }
        return $this->userContract->updateById($objUser->id, $data);
    }

    /**
     * @param $id
     * @throws Exception
     */
    public function delete($id)
    {
        $objUser = $this->show($id);
        $this->userContract->deleteById($objUser->id);
    }

    public function myProfile()
    {
        return auth()->user();
    }

    /**
     * @param $data
     * @return Collection|Model
     * @throws CustomException
     */
    public function updateMyProfile($data)
    {
        try {
            $obj = $this->validateAccess((string)$data['password'], 'profile_error');
            unset($data['password']);
            return $this->userContract->updateById($obj->id, $data);
        } catch (CustomException $e) {
            throw $e;
        }
    }

    /**
     * @param $data
     * @throws CustomException
     */
    public function updateMyPassword($data)
    {
        try {
            $obj = $this->validateAccess($data['password_actual'], 'password_error');
            $this->userContract->updateById($obj->id, ['password' => Hash::make($data['password_new'])]);
        } catch (CustomException $e) {
            throw $e;
        }
    }

    /**
     * @param string $password
     * @param string $typeError
     * @return Authenticatable|null
     * @throws CustomException
     */
    private function validateAccess(string $password, string $typeError): ?Authenticatable
    {
        $obj = auth()->user();
        if(!Auth::attempt(['email' => auth()->user()->email, 'password' => $password])){
            throw new CustomException(__('A sua senha está incorreta'), Response::HTTP_BAD_REQUEST, $typeError);
        }
        return $obj;
    }
}
