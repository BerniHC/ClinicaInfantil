<?php

class ImagesController extends BaseController 
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
            'image' => array('required', 'max:5120', 'mimes:jpg,jpeg,bmp,png,gif') // 5 MB
        );

        $validator = Validator::make(Input::all(), $rules);
        
        if($validator->fails()) 
            return 'ERROR: ' . $validator->messages()->first('image');

        DB::beginTransaction();

        try {
            $file = Input::file('image');
            
            $name = $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $path = storage_path() . "/images";
            
            if(File::exists($path.'/'.$name)) 
                throw new Exception('ERROR: Ya existe una imagen con el mismo nombre.');

            $file->move($path, $name);

            $img = Intervention::make($path.'/'.$name);
            $img->resize(1500, 1200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $img->save($path.'/'.$name);

            $image = new Image;
            $image->filename = $name;
            $image->path = $path;
            $image->expedient_id = $expedient_id;
            
            if(!$image->save())
                throw new Exception('Error al guardar la imagen.');
                
            DB::commit();

            $img->resize(94, 70, function ($constraint) {
                $constraint->aspectRatio();
            });

            $result = array(
                'url' => URL::route('image-download', $image->id),
                'type' => $ext,
                'date' => date('d/m/Y h:i a', strtotime($image->created_at)),
                'image' => (string) $img->encode('data-url'),
                'delete' => URL::route('image-delete', $image->id)
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

        $image = Image::findOrFail($id);
        
        $img = $image->path . "/" . $image->filename;

        return Response::download($img);
    }
    
    //----------------------------------------------------------
    // Delete Action
    //----------------------------------------------------------
    
    // GET
    public function get_delete($id)
    {
        if(!Auth::user()->can("edit-expedients"))
            App::abort('403');

        $image = Image::findOrFail($id);

        File::delete($image->path.'/'.$image->filename);
        
        if($image->delete())
            Session::flash('success', 'La imagen ha sido eliminada correctamente.');
        else
            Session::flash('error', 'No ha sido posible eliminar la imagen.');

        return Redirect::action('ExpedientsController@get_view', array('id' => $image->expedient_id));
    }

}