<!DOCTYPE html>
<html>
<head>
    <title>Analyze Sample</title>
    <script type='text/javascript' src='/js/jquery-3.3.1.min.js'></script>
</head>
<body>
<script type="text/javascript">

    function test(id){
        alert(id);
    }
    function processImage(id) {
        // **********************************************
        // *** Update or verify the following values. ***
        // **********************************************
 
        // Replace <Subscription Key> with your valid subscription key.
        var subscriptionKey = "64216a6e8c584678a20b32ea6433dfbd";
 
        // You must use the same Azure region in your REST API method as you used to
        // get your subscription keys. For example, if you got your subscription keys
        // from the West US region, replace "westcentralus" in the URL
        // below with "westus".
        //
        // Free trial subscription keys are generated in the "westus" region.
        // If you use a free trial subscription key, you shouldn't need to change
        // this region.
        var uriBase =
            "https://southeastasia.api.cognitive.microsoft.com/vision/v2.0/analyze";
 
        // Request parameters.
        var params = {
            "visualFeatures": "Categories,Description,Color",
            "details": "",
            "language": "en",
        };
 
        // Display the image.
        var sourceImageUrl = document.getElementById("inputImage").value;
        document.querySelector("#sourceImage").src = sourceImageUrl;
 
        // Make the REST API call.
        $.ajax({
            url: uriBase + "?" + $.param(params),
 
            // Request headers.
            beforeSend: function(xhrObj){
                xhrObj.setRequestHeader("Content-Type","application/json");
                xhrObj.setRequestHeader(
                    "Ocp-Apim-Subscription-Key", subscriptionKey);
            },
 
            type: "POST",
 
            // Request body.
            data: '{"url": ' + '"' + sourceImageUrl + '"}',
        })
 
        .done(function(data) {
            // Show formatted JSON on webpage.
            $("#responseTextArea").val(JSON.stringify(data, null, 2));
        })
 
        .fail(function(jqXHR, textStatus, errorThrown) {
            // Display error message.
            var errorString = (errorThrown === "") ? "Error. " :
                errorThrown + " (" + jqXHR.status + "): ";
            errorString += (jqXHR.responseText === "") ? "" :
                jQuery.parseJSON(jqXHR.responseText).message;
            alert(errorString);
        });
    };
</script>
 <form>
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
                echo "<img id=img".$no." src=".$blob->getUrl()." height=300 width=500 />";
                echo "
                      <div id='jsonOutput".$no."' style='width:400px;'>
                    Response:
                    <br>
                    <textarea id='responseTextArea".$no."' class='UIInput'
                              style='width:300px; height:300px;'></textarea>
                
                </div>";
                echo "<br>";
                echo "<button onclick='test('".$blob->getUrl()."')'>Analyze image</button>";
                echo "<br>";
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

 </form>
</body>
</html>
