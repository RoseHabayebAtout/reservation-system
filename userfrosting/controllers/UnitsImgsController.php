<?php

namespace UserFrosting;


class UnitsImgsController extends \UserFrosting\BaseController
{

    protected static $_table_id = "units_images";

    /**
     * Create a new UserController object.
     *
     * @param UserFrosting $app The main UserFrosting app.
     */
    public function __construct($app)
    {
        $this->_app = $app;
    }

    public function Images()
    {
        $post = $this->_app->request->post();

        $unit = UnitsImgs::where('img_id', '=', $post['img_id'])->get();
        //   $unit = UnitsImgs::find();
        echo $unit;
    }

    public function delImages()
    {
        $post = $this->_app->request->post();
        $unit = UnitsImgs::find($post['id']);
        $unit->delete();
        echo "ayat";

    }

    public function setImages()
    {

        // Fetch the POSTed data
        $post = $this->_app->request->post();


        $new_unit = new UnitsImgs([
            "unit_id" => $post['unit_id'],
            "img_id" => $post['img_id']
        ]);
        // echo $post['unit_id']+"ayat";
        $new_unit->save();
        // echo $post['addition_date']+"ayat";

    }

    public function getImagesID($unit_id)
    {

        // Fetch the POSTed data
        $units = UnitsImgs::where('unit_id', '=', $unit_id)->get();
//echo '<pre>';
//        print_r(['$unit_id' => $unit_id, '$units' => $units]);
//echo '</pre>';
//        die();
        $unitInfo = Unit::find($unit_id);
        $unitInfo['img'] = $units;
        echo $unitInfo;
        //echo $units;
    }


}



