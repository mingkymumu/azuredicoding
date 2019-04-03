<?php
require_once 'vendor/autoload.php';
require_once "./random_string.php";

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;


$connectionString = "DefaultEndpointsProtocol=https;AccountName=webappdicoding;AccountKey=mxkB+bJQO4L/+KDpTCOLHE9KHi8H2rk3FHO8a3Ve4KTyAzSTwn12zmRen8INMXhtlL5JpxNdscVh0vsyD68XkA==";

// Create blob client.
$blobClient = BlobRestProxy::createBlobService($connectionString);


$createContainerOptions = new CreateContainerOptions();

$createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

// Set container metadata.
$createContainerOptions->addMetaData("key1", "value1");
$createContainerOptions->addMetaData("key2", "value2");

$containerName = "blobgambar";


    try {
              // List blobs.
        $listBlobsOptions = new ListBlobsOptions();
        // $listBlobsOptions->setPrefix("HelloWorld");

      

        do{
            $no =1;
            $result = $blobClient->listBlobs($containerName, $listBlobsOptions);
            foreach ($result->getBlobs() as $blob)
            {
                // echo $blob->getName().": ".$blob->getUrl()."<br />";
                echo "<img id=".$no." src=".$blob->getUrl()." height=200 width=300 />";
                echo "<button>Analyze image</button>";
                echo "<br>";
                $no++;

            }
        
            $listBlobsOptions->setContinuationToken($result->getContinuationToken());
        } while($result->getContinuationToken());
        // echo "<br />";

        // Get blob.
        // echo "This is the content of the blob uploaded: ";
        // $blob = $blobClient->getBlob($containerName, $fileToUpload);
        // fpassthru($blob->getContentStream());
        // echo "<br />";
    }
    catch(ServiceException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message."<br />";
    }
    catch(InvalidArgumentTypeException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179439.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message."<br />";
    }




?>
