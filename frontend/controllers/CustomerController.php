<?php

namespace frontend\controllers;

use common\components\Notification;
use ruskid\csvimporter\CSVImporter;
use SplFileObject;
use Yii;
use frontend\models\Customer;
use frontend\models\CustomerSearch;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use ruskid\csvimporter\CSVReader;
use ruskid\csvimporter\MultipleImportStrategy;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'importSheet' => ['POST'],
                    'deleteFile' => ['POST'],
                    'importChunks' => ['POST'],
                ],
            ],
        ];
    }
    public function actionOpenFile($filename)
    {
        ob_clean();
        \Yii::$app->response->sendFile($filename)->send();
    }
    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $fileChunks = glob("*.csv");

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'fileChunks' => $fileChunks
        ]);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        //dentro do main, modules - ip do user é setado para verificar quem poderá visualizar a notificação.
        //Notification::success(Notification::KEY_BIRTHDAY_REMINDER, Yii::$app->user->id, $model->id);
        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customer();

        if ($model->load(Yii::$app->request->post()) ) {

            $model->birthday = implode("-", array_reverse(explode("/", $model->birthday)));
            $model->phone1 = preg_replace('/[^0-9]/', '',utf8_encode($model->phone1));
            $model->phone2 = preg_replace('/[^0-9]/', '',utf8_encode($model->phone2));
            $model->phone3 = preg_replace('/[^0-9]/', '',utf8_encode($model->phone3));
            $model->cell = preg_replace('/[^0-9]/', '',utf8_encode($model->cell));
            $model->zip_code = preg_replace('/[^0-9]/', '',utf8_encode($model->zip_code));

            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->birthday = implode("-", array_reverse(explode("/", $model->birthday)));
            $model->phone1 = preg_replace('/[^0-9]/', '',utf8_encode($model->phone1));
            $model->phone2 = preg_replace('/[^0-9]/', '',utf8_encode($model->phone2));
            $model->phone3 = preg_replace('/[^0-9]/', '',utf8_encode($model->phone3));
            $model->cell = preg_replace('/[^0-9]/', '',utf8_encode($model->cell));
            $model->zip_code = preg_replace('/[^0-9]/', '',utf8_encode($model->zip_code));

            if ($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUploadFile(){

        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = [];
        $model = $this->findModel(intval($_POST['id']));

        if (Yii::$app->request->isAjax && isset($_FILES)) {
            $model->load(Yii::$app->request->post());
            $model->file = UploadedFile::getInstance($model, 'file');

            $pathFile = $model->folder . '/' . $model->file->baseName . '.' . $model->file->extension;
            if(!empty($pathFile) && file_exists($pathFile))
                unlink($pathFile);

            $model->file->saveAs($pathFile, false);
            $data = ['success' => true, 'msg' => 'Arquivo enviado com sucesso.'];
        }
        else
            $data = ['success' => false, 'msg' => 'Erro na importação do arquivo'];

        return $data;
    }

    public function actionDeleteFile(){

        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = [];
        $file =  Yii::$app->request->post('file');
        if (Yii::$app->request->isAjax && file_exists($file)) {
            unlink($file);
            $data = ['success' => true, 'msg' => 'Arquivo deletado com sucesso.'];
        }
        else
            $data = ['success' => false, 'msg' => 'Erro na deleção do arquivo'];

        return $data;
    }


    public function sliceFile($inputFile){
        $outputFile = $inputFile['name'];

        $splitSize = 500;

        $in = fopen($inputFile['tmp_name'], 'r');

        $rowCount = 0;
        $fileCount = 1;
        $out = null;
        $header = null;
        $files = [];

        while (($line = fgetcsv($in, 0, ';', '"', '\\')) !== FALSE) {
            if (($rowCount % $splitSize) == 0) {
                if ($rowCount > 0) {
                    fclose($out);
                }
                $fileChunkName = $outputFile . $fileCount++ . '.csv';
                $out = fopen($fileChunkName, 'w');
                array_push($files, $fileChunkName);
                if($header != null)
                    fputcsv($out, $header, ';');
            }
            if ($line){
                if($rowCount == 0)
                    $header = $line;
                fputcsv($out, $line, ';');
            }
            $rowCount++;
        }

        fclose($out);
        return $files;
    }

    public function actionImportSheet(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = [];
        $numberRowsAffected = 0;

        if(Yii::$app->request->isAjax && isset($_FILES['excelSheet'])) {

            $fileChunks = $this->sliceFile($_FILES['excelSheet']);
            $numberRowsAffected = $this->processChunk($fileChunks);
            $data = ['success' => true, 'msg' => $numberRowsAffected . ' Importados'];
        }
        else
            $data = ['success' => false, 'msg' => 'Requisição incorreta.'];

        return $data;
    }

    public function actionImportChunks(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = [];
        $numberRowsAffected = 0;

        $fileChunks =  $fileChunks = glob("*.csv");
        if(Yii::$app->request->isAjax && sizeof($fileChunks) > 0) {
            $numberRowsAffected = $this->processChunk($fileChunks);
            $data = ['success' => true, 'msg' => $numberRowsAffected . ' Importados'];
        }
        else
            $data = ['success' => false, 'msg' => 'Requisição incorreta.'];

        return $data;
    }

    public function processChunk($fileChunks){

        $numberRowsAffected = 0;
        foreach ($fileChunks as $fil) {
            if(file_exists($fil)) {

                try {
                    $importer = new CSVImporter;
                    $importer->setData(new CSVReader([
                        'filename' => $fil /*Yii::$app->basePath."/controllers/teste.csv"*/,
                        'fgetcsvOptions' => [
                            'delimiter' => ';'
                        ]
                    ]));

                    //Import multiple (Fast but not reliable). Will return number of inserted rows
                    $numberRowsAffected += $importer->import(new MultipleImportStrategy([
                        'tableName' => Customer::tableName(),
                        'className' => Customer::className(),
                        'configs' => [
                            //name
                            [
                                'attribute' => 'name',
                                'value' => function ($line) {
                                    return utf8_encode($line[7]);
                                },
                            ],
                            //birthday
                            [
                                'attribute' => 'birthday',
                                'value' => function ($line) {
                                    return implode("-", array_reverse(explode("/", utf8_encode($line[8]))));
                                },
                            ],
                            //document
                            [
                                'attribute' => 'document',
                                'value' => function ($line) {
                                    return utf8_encode($line[5]);
                                },
                                //'unique' => true, //Will filter and import unique values only. can by applied for 1+ attributes
                            ],
                            //agency
                            [
                                'attribute' => 'agency',
                                'value' => function ($line) {
                                    return utf8_encode($line[2]);
                                },
                            ],
                            //registry
                            [
                                'attribute' => 'registry',
                                'value' => function ($line) {
                                    return utf8_encode($line[6]);
                                },
                            ],
                            //address
                            [
                                'attribute' => 'address',
                                'value' => function ($line) {
                                    return utf8_encode($line[9]) . ', ' . utf8_encode($line[10]);
                                },
                            ],
                            //complement
                            [
                                'attribute' => 'complement',
                                'value' => function ($line) {
                                    return utf8_encode($line[11]);
                                },
                            ],
                            //zip_code
                            [
                                'attribute' => 'zip_code',
                                'value' => function ($line) {
                                    return preg_replace('/[^0-9]/', '', utf8_encode($line[15]));
                                },
                            ],
                            //neighbourhood
                            [
                                'attribute' => 'neighbourhood',
                                'value' => function ($line) {
                                    return utf8_encode($line[12]);
                                },
                            ],
                            //city
                            [
                                'attribute' => 'city',
                                'value' => function ($line) {
                                    return utf8_encode($line[13]);
                                },
                            ],
                            //state
                            [
                                'attribute' => 'state',
                                'value' => function ($line) {
                                    return utf8_encode($line[14]);
                                },
                            ],
                            //phone1
                            [
                                'attribute' => 'phone1',
                                'value' => function ($line) {
                                    return preg_replace('/[^0-9]/', '', utf8_encode(utf8_encode($line[16]) . $line[17]));
                                },
                            ],
                            //phone2
                            [
                                'attribute' => 'phone2',
                                'value' => function ($line) {
                                    return preg_replace('/[^0-9]/', '', utf8_encode(utf8_encode($line[18]) . $line[19]));
                                },
                            ],
                            //phone3
                            [
                                'attribute' => 'phone3',
                                'value' => function ($line) {
                                    return preg_replace('/[^0-9]/', '', utf8_encode(utf8_encode($line[20]) . $line[21]));
                                },
                            ],
                            //cell
                            [
                                'attribute' => 'cell',
                                'value' => function ($line) {
                                    return preg_replace('/[^0-9]/', '', utf8_encode(utf8_encode($line[22]) . $line[23]));
                                },
                            ],
                            //mail
                            /*[
                                'attribute' => 'mail',
                                'value' => function ($line) {
                                    return utf8_encode($line[14]);
                                },
                            ],*/
                            //customer_password
                            [
                                'attribute' => 'customer_password',
                                'value' => function ($line) {
                                    return utf8_encode($line[25]);
                                },
                            ],
                            //observation
                            /*[
                                'attribute' => 'observation',
                                'value' => function ($line) {
                                    return utf8_encode($line[16]);
                                },
                            ],*/
                            //telemarketing
                            /*[
                                'attribute' => 'telemarketing',
                                'value' => function ($line) {
                                    return utf8_encode($line[17]);
                                },
                            ]*/
                        ],
                        'skipImport' => function ($line) {
                            if (empty($line[7]) || $line[7] == "") {
                                return true;
                            }
                            if (empty($line[8]) || $line[8] == "") {
                                return true;
                            }

                            if (!empty($line[5])) {
                                $model = Customer::findByDocument($line[5]);
                                if ($model)
                                    return true;
                            }
                        }
                    ]));


                    unlink($fil);

                } catch (Exception $ex) {
                    $data = ['success' => false, 'msg' => 'Erro na importação do arquivo'];
                }
            }
        }
        return $numberRowsAffected;
    }

    public function beforeAction($action) {
        if($action->id == 'index')
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /* public function actionImportSheet(){
         Yii::$app->response->format = Response::FORMAT_JSON;
         $data = [];

         if(Yii::$app->request->isAjax && isset($_FILES['excelSheet'])) {

             try {
                 $excelSheet = $_FILES['excelSheet'];

                 $temp = $_FILES["excelSheet"]["temp_name"];
                 $name = $_FILES["excelSheet"]["name"];

                 move_uploaded_file($temp, Yii::$app->basePath."/controllers/".$name);

                 $fp = new SplFileObject($excelSheet["tmp_name"], 'r');
                 $fp->seek(PHP_INT_MAX);
                 $total = $fp->key() + 1;
                 $fp->rewind();

                 $numberRowsAffected = 0;
                 $chunks = 501;
                 $completeLinesArray = null;
                 for($cont = 1; $cont < $total; $cont = ( ($cont+$chunks) > $total ? $total : ($cont+$chunks))) {

                     $importer = new CSVImporter;
                     $csvReader = new CSVReader([
                         'filename' => Yii::$app->basePath."/controllers/".$name,
                         'fgetcsvOptions' => [
                             'delimiter' => ';',
                             'startFromLine' => $cont,
                             'stopOnLine' => $chunks,
                             'completeLinesArray' => $completeLinesArray
                         ]
                     ]);
                     $importer->setData($csvReader);
                     $completeLinesArray = $csvReader->getCompleteLinesArray();

                     //Import multiple (Fast but not reliable). Will return number of inserted rows
                     $numberRowsAffected += $importer->importByReflection(new MultipleImportStrategy([
                         'tableName' => Customer::tableName(),
                         'className' => Customer::className(),
                         'configs' => [
                             //name
                             [
                                 'attribute' => 'name',
                                 'value' => function ($line) {
                                     return utf8_encode($line[7]);
                                 },
                             ],
                             //birthday
                             [
                                 'attribute' => 'birthday',
                                 'value' => function ($line) {
                                     return implode("-", array_reverse(explode("/", utf8_encode($line[8]))));
                                 },
                             ],
                             //document
                             [
                                 'attribute' => 'document',
                                 'value' => function ($line) {
                                     return utf8_encode($line[5]);
                                 },
                                 'unique' => true, //Will filter and import unique values only. can by applied for 1+ attributes
                             ],
                             //agency
                             [
                                 'attribute' => 'agency',
                                 'value' => function ($line) {
                                     return utf8_encode($line[2]);
                                 },
                             ],
                             //registry
                             [
                                 'attribute' => 'registry',
                                 'value' => function ($line) {
                                     return utf8_encode($line[6]);
                                 },
                             ],
                             //address
                             [
                                 'attribute' => 'address',
                                 'value' => function ($line) {
                                     return utf8_encode($line[9]) . ', ' . utf8_encode($line[10]);
                                 },
                             ],
                             //complement
                             [
                                 'attribute' => 'complement',
                                 'value' => function ($line) {
                                     return utf8_encode($line[11]);
                                 },
                             ],
                             //zip_code
                             [
                                 'attribute' => 'zip_code',
                                 'value' => function ($line) {
                                     return preg_replace('/[^0-9]/', '', utf8_encode($line[15]));
                                 },
                             ],
                             //neighbourhood
                             [
                                 'attribute' => 'neighbourhood',
                                 'value' => function ($line) {
                                     return utf8_encode($line[12]);
                                 },
                             ],
                             //city
                             [
                                 'attribute' => 'city',
                                 'value' => function ($line) {
                                     return utf8_encode($line[13]);
                                 },
                             ],
                             //state
                             [
                                 'attribute' => 'state',
                                 'value' => function ($line) {
                                     return utf8_encode($line[14]);
                                 },
                             ],
                             //phone1
                             [
                                 'attribute' => 'phone1',
                                 'value' => function ($line) {
                                     return preg_replace('/[^0-9]/', '', utf8_encode(utf8_encode($line[16]) . $line[17]));
                                 },
                             ],
                             //phone2
                             [
                                 'attribute' => 'phone2',
                                 'value' => function ($line) {
                                     return preg_replace('/[^0-9]/', '', utf8_encode(utf8_encode($line[18]) . $line[19]));
                                 },
                             ],
                             //phone3
                             [
                                 'attribute' => 'phone3',
                                 'value' => function ($line) {
                                     return preg_replace('/[^0-9]/', '', utf8_encode(utf8_encode($line[20]) . $line[21]));
                                 },
                             ],
                             //cell
                             [
                                 'attribute' => 'cell',
                                 'value' => function ($line) {
                                     return preg_replace('/[^0-9]/', '', utf8_encode(utf8_encode($line[22]) . $line[23]));
                                 },
                             ],
                             //customer_password
                             [
                                 'attribute' => 'customer_password',
                                 'value' => function ($line) {
                                     return utf8_encode($line[25]);
                                 },
                             ],
                         ],
                         'skipImport' => function ($line) {
                             if (empty($line[7]) || $line[7] == "") {
                                 return true;
                             }
                             if (empty($line[8]) || $line[8] == "") {
                                 return true;
                             }

                             if (!empty($line[5])) {
                                 $model = Customer::findByDocument($line[5]);
                                 if ($model)
                                     return true;
                             }
                         }
                     ]));
                 }

                 $data = ['success' => true, 'msg' => $numberRowsAffected . ' Importados'];

             }catch (Exception $ex){
                 $data = ['success' => false, 'msg' => 'Erro na importação do arquivo'];
             }
         }
         else
             $data = ['success' => false, 'msg' => 'Erro na importação do arquivo'];

         //throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
         return $data;
     }*/
}
