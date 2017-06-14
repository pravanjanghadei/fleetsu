<?php

use Illuminate\Database\Seeder;

use App\Model\Device;
class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $device 				=	new Device();
        $device->device_name 	=	'laptop';
        $device->save();

        $device 				=	new Device();
        $device->device_name 	=	'desktop';
        $device->save();

        $device 				=	new Device();
        $device->device_name 	=	'mobile';
        $device->save();

        
        $device 				=	new Device();
        $device->device_name 	=	'fan';
        $device->save();

        
    }
}
