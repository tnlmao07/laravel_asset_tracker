<?php
namespace App\Http\Controllers;
use App\Models\AssetType;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AdminController extends Controller
{
    /* ----------- Code for Charts Dashboard ---------------------------*/
    public function dashBoard(){
        /* ------------Pie Chart------------- */
        $chartData="";
        $result = DB::select(DB::raw("SELECT status , COUNT('status') as count FROM assets GROUP BY status"));
        foreach($result as $list){
            $chartData.="['".$list->status."',     ".$list->count."],";
        }
        /* ------------Bar Chart--------------- */
        $chartDatabar="";
        $resultbar=DB::select(DB::raw("SELECT name, COUNT(name) as count FROM assets GROUP BY name;"));
        foreach($resultbar as $list){
            $chartDatabar.="['".$list->name."',     ".$list->count."],";
        }
        
       $arr['chartData'] = rtrim($chartData,",");
       $arr['chartDatabar']=rtrim($chartDatabar,",");
       return view('dashboard',$arr);
    }
    /* ----------- Code for Asset Management Dashboard ---------------------------*/
    public function assetHome(){
        return view('assets');
    }
    /* ----------- Code for  Asset type dashoard view---------------------------*/
    public function assetType(){
        $assettype=AssetType::all();
        $data= compact('assettype');
        return view('asset-type')->with($data);
    }
    /* ----------- Code for  Asset type form view---------------------------*/
    public function assetTypeForm(){  
        $url=url('/asset-type-form');
        $title= "Create Asset Type";
        $data=compact('url','title');
       
        return view('asset-type-form')->with($data);
    }
    /* ----------- Code for  Asset type insertion---------------------------*/
    public function assetTypeFormPost(Request $request){  
        $request->validate(
            [
                'assettype'=>'required',
                'assetdesc'=>'required'
            ]
        );
        $assettype=new AssetType;
        $assettype->asset_type =$request['assettype'];
        $assettype->asset_description =$request['assetdesc'];
        $assettype->save();
        return redirect('asset-type');
    }
    /* ----------- Code for asset deletion ---------------------------*/
    public function deleteAssetType($id){
        AssetType::find($id)->delete();
        return redirect()->back();
    }
    /* ----------- Code for asset type updation form ---------------------------*/
    public function editAssetType($id){
        $assettype=AssetType::find($id);
        if(is_null($assettype)){
            return redirect()->back();
        }else{
            $url=url('/update')."/".$id;
            $title="Update Asset Type";
            $data=compact('assettype','url','title');
            return view('asset-type-form-update')->with($data);
        }
    }
    /* ----------- Code for Asset type updation ---------------------------*/
    public function updateAssetType($id,Request $request){
        $request->validate(
            [
                'assettype'=>'required',
                'assetdesc'=>'required'
            ]
        );
        $assettype=AssetType::find($id);
        $assettype->asset_type =$request['assettype'];
        $assettype->asset_description =$request['assetdesc'];
        $assettype->save();
        return redirect('asset-type');
    }
    /* ----------- Code for  Assets dashboard---------------------------*/
    public function asset(){
        $asset=Asset::all();
        $data= compact('asset');
        return view('asset')->with($data);
    }
    /* ----------- Code for Asset insertion form view ---------------------------*/
    public function assetForm(){
        $assettype=AssetType::all();
        $data=compact('assettype');
        return view('asset-form')->with($data);
    }
    /* ----------- Code for  Asset Insertion ---------------------------*/
    public function assetFormPost(Request $request){
        $request->validate(
            [
                'assetname'=>'required',
                'uuid'=>'required',
                'file'=>'required'
            ]
        );
        $asset=new Asset;
        $asset->name =$request['assetname'];
        $asset->uuid =$request['uuid'];
        $asset->asset_type_id =$request['assettypeid'];
        $test=$request->file('file')->move('storage\app\public\uploads', $asset->uuid.'.jpg');
        $asset->image="".$test;
        $asset->save();
        $assetdata=Asset::all();
        $data=compact('assetdata');
        return redirect('asset')->with($data);
    }
    /* ----------- Code for  Asset deletion---------------------------*/
    public function deleteAsset($id){
        Asset::find($id)->delete();
        return redirect()->back();
    }
    /* ----------- Code for Asset updation form ---------------------------*/
    public function editAsset($id){
        $assettype=AssetType::all();
        $asset=Asset::find($id);
        if(is_null($asset)){
            return redirect()->back();
        }else{
            $url=url('/updateasset')."/".$id;
            $title="Update Asset";
            $data=compact('asset','url','title','assettype');
            return view('asset-form-update')->with($data);
        }
    }
    /* ----------- Code for Asset Updation ---------------------------*/
    public function updateAsset($id,Request $request){
        $request->validate(
            [
                'assetname'=>'required',
                'uuid'=>'required',
                'file'=>'required'
            ]
        );
        $asset=Asset::find($id);

        $asset->name =$request['assetname'];
        $asset->uuid =$request['uuid'];
        $asset->asset_type_id =$request['assettypeid'];
        $test=$request->file('file')->move('storage\app\public\uploads', $asset->uuid.'.jpg');
        $asset->image="".$test;
        $asset->save();
        /* echo "<echo>";
        return $asset; */
        return redirect('asset');
    }
    /* ----------- Code for Logging out ---------------------------*/
    public function logout(){
        return view('login');
    }
}
