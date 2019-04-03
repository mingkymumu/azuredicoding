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


if(isset($_POST['Submit1']))
{ 
    $createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

    // Set container metadata.
    $createContainerOptions->addMetaData("key1", "value1");
    $createContainerOptions->addMetaData("key2", "value2");
	$containerName = "blockblobs".generateRandomString();

    $filepath = "image/".$_FILES["file"]["name"];
    if(move_uploaded_file($_FILES["file"]["tmp_name"], $filepath)) 
    {
        $fileToUpload = $filepath;
        try {
            // Create container.
            $blobClient->createContainer($containerName, $createContainerOptions);
    
            // Getting local file so that we can upload it to Azure
            $myfile = fopen($filepath, "w") or die("Unable to open file!");
            fclose($myfile);
            
            # Upload file as a block blob
         //   echo "Uploading BlockBlob: ".PHP_EOL;
         //   echo $fileToUpload;
         //   echo "<br />";
            
            $content = fopen($fileToUpload, "r");
    
            //Upload blob
            $blobClient->createBlockBlob($containerName, $fileToUpload, $content);
    
            // List blobs.
            $listBlobsOptions = new ListBlobsOptions();
            $listBlobsOptions->setPrefix("HelloWorld");
    
    
            do{
                $result = $blobClient->listBlobs($containerName, $listBlobsOptions);
                foreach ($result->getBlobs() as $blob)
                {
                    echo "<img src=".$blob->getUrl()." height=200 width=300 />";
                }
            
                $listBlobsOptions->setContinuationToken($result->getContinuationToken());
            } while($result->getContinuationToken());
    
            // Get blob.
            $blob = $blobClient->getBlob($containerName, $fileToUpload);
            fpassthru($blob->getContentStream());
            
        }
        catch(ServiceException $e){
            // Handle exception based on error codes and messages.
            // Error codes and messages are here:
            // http://msdn.microsoft.com/library/azure/dd179439.aspx
            $code = $e->getCode();
            $error_message = $e->getMessage();
            echo $code.": ".$error_message;
        }
        catch(InvalidArgumentTypeException $e){
            // Handle exception based on error codes and messages.
            // Error codes and messages are here:
            // http://msdn.microsoft.com/library/azure/dd179439.aspx
            $code = $e->getCode();
            $error_message = $e->getMessage();
            echo $code.": ".$error_message."<br />";
        }
    }
	
} 
// else 
// {

//     try{
//         // Delete container.
//         echo "Deleting Container".PHP_EOL;
//         echo $_GET["containerName"].PHP_EOL;
//         echo "<br />";
//         $blobClient->deleteContainer($_GET["containerName"]);
//     }
//     catch(ServiceException $e){
//         // Handle exception based on error codes and messages.
//         // Error codes and messages are here:
//         // http://msdn.microsoft.com/library/azure/dd179439.aspx
//         $code = $e->getCode();
//         $error_message = $e->getMessage();
//         echo $code.": ".$error_message."<br />";
//     }
// }
?>
<form action="upload.php" enctype="multipart/form-data" method="post">
Select image :
<input type="file" name="file"><br/>
<input type="submit" value="Upload" name="Submit1"> <br/>
 </form>
