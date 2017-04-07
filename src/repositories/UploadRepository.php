<?php

namespace Jaspur\Dropzoner\Repositories;

use Jaspur\Dropzoner\Events\FileWasDeleted;
use Jaspur\Dropzoner\Events\FileWasUploaded;

class UploadRepository
{
    /**
     * Upload Single Image
     *
     * @param $input
     * @return mixed
     */
    public function upload($input)
    {
        $validator = \Validator::make($input, config('dropzoner.validator'), config('dropzoner.validator-messages'));

        if ($validator->fails()) {

            return response()->json([
                'error'   => true,
                'message' => $validator->messages()->first(),
                'code'    => 400,
            ], 400);
        }

        $file = $input['file'];

        $original_name                   = $file->getClientOriginalName();
        $extension                       = $file->getClientOriginalExtension();
        $original_name_without_extension = substr($original_name, 0, strlen($original_name) - strlen($extension) - 1);

        $filename         = $this->sanitize($original_name_without_extension);
        $allowed_filename = $this->createUniqueFilename($filename);

        $filename_with_extension = $allowed_filename . '.' . $extension;

        $file->storeAs(config('dropzoner.upload-path'), $filename_with_extension);

        //Fire FileWasUploaded Event
        event(new FileWasUploaded($original_name, $filename_with_extension, $extension));

        return response()->json([
            'error'    => false,
            'code'     => 200,
            'filename' => $filename_with_extension,
        ], 200);
    }

    /**
     * Delete Single Image
     *
     * @param $server_filename
     * @return mixed
     */
    public function delete($server_filename)
    {
        $upload_path = config('dropzoner.upload-path');

        $full_path = $upload_path . $server_filename;

        if (\File::exists($full_path)) {
            \File::delete($full_path);
        }

        event(new FileWasDeleted($server_filename));

        return response()->json([
            'error' => false,
            'code'  => 200,
        ], 200);
    }

    /**
     * Check upload directory and see it there a file with same filename
     * If filename is same, add random 5 char string to the end
     *
     * @param $filename
     * @return string
     */
    private function createUniqueFilename($filename)
    {
        $full_size_dir   = config('dropzoner.upload-path');
        $full_image_path = $full_size_dir . $filename . '.jpg';

        if (\File::exists($full_image_path)) {
            // Generate token for image
            $image_token = substr(sha1(mt_rand()), 0, 5);
            return $filename . '-' . $image_token;
        }

        return $filename;
    }

    /**
     * Create safe file names for server side
     *
     * @param $string
     * @param bool $force_lowercase
     * @return mixed|string
     */
    private function sanitize($string, $force_lowercase = true)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);

        return ($force_lowercase) ?
        (function_exists('mb_strtolower')) ?
        mb_strtolower($clean, 'UTF-8') :
        strtolower($clean) :
        $clean;
    }
}
