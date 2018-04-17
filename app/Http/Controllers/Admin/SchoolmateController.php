<?php
/**
 * Created by PhpStorm.
 * User: 12394
 * Date: 2018-4-11
 * Time: 15:41
 */
namespace App\Http\Controllers\Admin;


use App\Models\School;
use App\Models\Schoolfellow;
use Illuminate\Http\Request;

class SchoolmateController extends BaseController
{
    public function index(){
        $school = School::paginate(10);
        $this->assign(['school'=>$school]);
        return $this->view('admin.schoolfellow.school');
    }
    public function application(){
        if ($this->isOnSubmit()){
            $req = $this->request->post('item');
            $application = Schoolfellow::find($req['id']);
            $updated_at = date('Y-m-d H:i:s');
            if($req['pass'] == '1'){
                $application->status = '1';
            }else{
                $application->status = '-1';
            }
            $application->updated_at = $updated_at;
            $application->save();
            return ajaxReturn();
        }else{
            $id = $this->request->get('id');
            $school = School::find($id);
            $members = $school->apply()->paginate(10);
            $this->assign(['list'=>$members,'school'=>$school]);
            return $this->view('admin.schoolfellow.application');
        }

    }
    public function applicationManager(){

    }
    public function schoolManager(){}
    public function schoolfellow(){
        $id = $this->request->get('id');
        $school = School::find($id);
        $members = $school->members()->paginate(10);
        $this->assign(['members'=>$members,'school'=>$school]);
        return $this->view('admin.schoolfellow.schoolfellow');
    }
    public function detail(){
        return $this->view('admin.schoolfellow.school');
    }

    public function editSchool(Request $request){
        $req = $request->all();
        $school = School::find($req['id']);
        $school['name'] = $req['name'];
        $school->save();
        return ajaxReturn();
    }

    public function dealSchool(Request $request){
        $req = $request->all();
        $school = School::find($req['id']);
        if($req['pass'] == '1'){
            $school['status'] = '1';
        }else{
            $school['status'] = '0';
        }
        $school->save();
        return ajaxReturn();
    }
}
