<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Uji_penentuan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!isAuthenticated()) {
            redirect(base_url('auth'));
        }
        provideAccessTo("1|2|3|5");
    }

    public function index()
    {
        $dataTesting = $this->Data_testing->all();
        $dataBaru = $this->Data_baru->all();

        $data = [
            'title' => 'Uji Penentuan',
            'data_testing' => $dataTesting,
            'data_baru' => $dataBaru,
            'no' => 1
        ];
        
        if (isset($_POST['uji'])) {
            $k = $this->input->post('k');

            $results = $this->calculateEuclideanDistance($dataTesting, $dataBaru);
            $data['results'] = $results;
            $data['k_value'] = $k;
        }

        $this->main_lib->getTemplate('knn/uji-penentuan', $data);
    }

    /**
     * @param array $dataTest
     * @param $dataBaru
     * @return array
     */
    private function calculateEuclideanDistance(array $dataTest, $dataBaru): array
    {
        $results = [];
        $nikBaru = $dataBaru[0]->nik;
        $nopolBaru = $dataBaru[0]->nopol;

        foreach ($dataTest as $data) {
            $nikTest = $data->nik;
            $nopolTest = $data->nopol;

            $nikCount = pow($nikTest - $nikBaru, 2);
            $nopolCount = pow($nopolTest - $nopolBaru, 2);

            $euclideanDistance = sqrt($nikCount + $nopolCount);

            $edPersen = number_format($euclideanDistance, 0);

            $results[] = [
                'nik' => $nikTest,
                'nopol' => $nopolTest,
                'euclidean_distance' => $euclideanDistance,
                'ed_persen' => $edPersen,
                'status' => $data->status_progresif !== '' && $data->status_progresif !== null ? 1 : 0
            ];
        }

        $columns = array_column($results, 'ed_persen');
        array_multisort($columns, SORT_ASC, $results);

        return $results;
    }
}

/* End of file Uji_penentuan.php */
