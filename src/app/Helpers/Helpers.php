<?php
// This is just temporary file

if (!function_exists('write_file')) {
    function write_file($path, $string, $needle, $replace = false)
    {
        $document = file_get_contents($path);
        $pos = strpos($document, $needle);

        $document = $replace ?
            str_replace($needle, $string, $document) : substr_replace($document, $string, $pos, 0);

        file_put_contents($path, $document);
    }
}
if (!function_exists('auto_module')) {
    function auto_module($module_name)
    {
        write_file(
            resource_path('js/store/modules/theme/menu.js'),
            "{ icon: 'help', text: '$module_name', route: '/" . \Str::kebab($module_name) . "', auth: true }, \n\t\t",
            '// #Autocrud#'
        );
        write_file(resource_path('js/router/routes.js'), "'$module_name', \n\t\t", '// #Autocrud#');


        $base_path = base_path('vendor/barq-dev/autocrud/src/Resources/js/vue/views/base');
        $dest_path = resource_path("js/views/" . \Str::snake($module_name));
        \File::copyDirectory($base_path, $dest_path);

        write_file("$dest_path/Index.vue", $module_name, '#MODULE#', true);
    }
}


// if (!function_exists('copy_dir')) {
//     function copy_dir($path, $destination)
//     {
//         $base_path = base_path('packages/barq-dev/autocrud/src/Resources/js/vue/views/base');
//         $dest_path = resource_path("js/views/" . \Str::snake($module_name));
//         \File::copyDirectory($base_path, $dest_path);
//     }
// }
