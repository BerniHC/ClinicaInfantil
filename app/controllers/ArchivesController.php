<?php

class ArchivesController extends BaseController 
{
    protected $layout = 'layouts.admin';
    
    //----------------------------------------------------------
    // Upload Action
    //----------------------------------------------------------

    // POST
    public function post_upload($expedient_id) {
        if(!Auth::user()->can("edit-expedients"))
            App::abort('403');
        
        $rules = array(
            'file' => array('required', 'max:51200') // 50 MB
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if($validator->fails()) 
            return 'ERROR: ' . $validator->messages()->first('file');

        DB::beginTransaction();

        try {
            $file = Input::file('file');
            
            $name = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $path = storage_path()."/files";
            
            if(File::exists($path.'/'.$name)) 
                throw new Exception('ERROR: Ya existe un archivo con el mismo nombre.');

            $archive = new Archive;
            $archive->filename = $name;
            $archive->path = $path;
            $archive->expedient_id = $expedient_id;
            
            if(!$archive->save())
                throw new Exception('Error al guardar el archivo.');

            $file->move(storage_path() . "/files", $name);
            
            DB::commit();
            
            $result = array(
                'url' => URL::route('archive-download', $archive->id),
                'type' => $ext,
                'date' => date('d/m/Y h:i a', strtotime($archive->created_at)),
                'delete' => URL::route('archive-delete', $archive->id)
            );

            return json_encode($result);
        }
        catch (\Exception $ex) 
        {
            DB::rollback();
            Log::error($ex);

            return $ex->getMessage();
        }
    }
    
    //----------------------------------------------------------
    // Download Action
    //----------------------------------------------------------
    
    // GET
    public function get_download($id)
    {
        if(!Auth::user()->can("view-expedients"))
            App::abort('403');

        $archive = Archive::findOrFail($id);
        
        $file = $archive->path . "/" . $archive->filename;

        return Response::download($file);
    }
    
    //----------------------------------------------------------
    // Delete Action
    //----------------------------------------------------------
    
    // GET
    public function get_delete($id)
    {
        if(!Auth::user()->can("edit-expedients"))
            App::abort('403');

        $archive = Archive::findOrFail($id);
        
        File::delete($archive->path.'/'.$archive->filename);
        
        if($archive->delete())
            Session::flash('success', 'El archivo ha sido eliminado correctamente.');
        else
            Session::flash('error', 'No ha sido posible eliminar el archivo.');

        return Redirect::back();
    }

}