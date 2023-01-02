<?php

namespace App\Http\Controllers;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;

use App\Model\Daftar_pegawai;

class FaceRecognitionController extends Controller
{
    public function rekamDataWajah()
    {
        if (!File::exists(public_path("face_recognition/datasementara"))) {
            File::makeDirectory(public_path("face_recognition/datasementara"));
        }

        $install_opencv = new Process("pip install opencv-python");
        $install_pillow = new Process("pip install opencv-python");
        $install_opencv->setTimeout(3600);
        $install_pillow->setTimeout(3600);
        $install_opencv->run();
        $install_pillow->run();

        $uniqid = uniqid();
        $path = public_path();
        $process = new Process("python ".public_path()."/face_recognition/face_dataset.py ".$path. ' '. $uniqid);
        $process->setTimeout(3600);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return response()->json($process->getOutput());
    }

    public function trainingData()
    {
        $install_opencv = new Process("pip install opencv-python");
        $install_pillow = new Process("pip install opencv-python");
        $install_opencv->run();
        $install_pillow->run();

        $daftar_pegawai = Daftar_pegawai::all();

        $process = null;
        foreach ($daftar_pegawai as $key_pegawai => $pegawai) {
            if (!File::exists(public_path("face_recognition/training"))) {
                File::makeDirectory(public_path("face_recognition/training"));
            }

            if (!File::exists(public_path("face_recognition/training/$pegawai->id"))) {
                File::makeDirectory(public_path("face_recognition/training/$pegawai->id"));
            }

            $path = public_path();
            $process = new Process("python ".public_path()."/face_recognition/face_training.py ".$path." ". $pegawai->id);
            $process->run();

            // executes after the command finishes
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
        }

        // Hapus Data sementara
        $all_files = File::allFiles('face_recognition/datasementara/');
        File::Delete($all_files);

        return response()->json($process ? $process->getOutput() : '');
    }

    public function scanWajah($id)
    {
        $install_opencv = new Process("pip install opencv-python");
        $install_pillow = new Process("pip install opencv-python");
        $install_opencv->run();
        $install_pillow->run();

        if (!File::exists(public_path("face_recognition/training"))) {
            File::makeDirectory(public_path("face_recognition/training"));
        }

        if (!File::exists(public_path("face_recognition/training/$id"))) {
            File::makeDirectory(public_path("face_recognition/training/$id"));
        }

        if (!File::exists(public_path("face_recognition/training/$id/trainer.yml"))) {
            return response()->json(false);
        }

        $path = public_path();
        $process = new Process("python ".public_path()."/face_recognition/face_recognition.py ".$path." ". $id);
        $process->setTimeout(3600);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return response()->json(filter_var($process->getOutput(), FILTER_VALIDATE_BOOLEAN));
    }
}
