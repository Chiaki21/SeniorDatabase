<?php
include('connect.php');
if (isset($_POST["create"])) {
    $RBIID = mysqli_real_escape_string($conn, $_POST["rbiid"]);
    $referenceCode = mysqli_real_escape_string($conn, $_POST["referenceCode"]);
    
    $imageFilePath = ''; // Initialize the variable for the image file path

    if (isset($_POST["imageData"])) {
        // Image data from the camera
        $imageData = $_POST["imageData"];
        $data = substr($imageData, strpos($imageData, ',') + 1);
        $decodedData = base64_decode($data);

        $filename = uniqid() . '.png';
        $targetFilePath = "imageuploaded/" . $filename;
        
        // Save the decoded image data to the target file
        if (file_put_contents($targetFilePath, $decodedData)) {
            $imageFilePath = $targetFilePath;
        }
    } elseif (isset($_FILES['imageup']['name'])) {
        // Image data from the file input
        $targetDirectory = "imageuploaded/";
        $targetFilePath = $targetDirectory . basename($_FILES["imageup"]["name"]);
        
        if (move_uploaded_file($_FILES["imageup"]["tmp_name"], $targetFilePath)) {
            $imageFilePath = $targetFilePath;
        }
    }

    $lastName = mysqli_real_escape_string($conn, $_POST["lastName"]);
    $firstName = mysqli_real_escape_string($conn, $_POST["firstName"]);
    $middleName = mysqli_real_escape_string($conn, $_POST["middleName"]);
    $extensionName = mysqli_real_escape_string($conn, $_POST["extensionName"]);
    $region = mysqli_real_escape_string($conn, $_POST["region"]);
    $province = mysqli_real_escape_string($conn, $_POST["province"]);
    $city = mysqli_real_escape_string($conn, $_POST["city"]);
    $barangay = mysqli_real_escape_string($conn, $_POST["barangay"]);
    $houseno = mysqli_real_escape_string($conn, $_POST["houseno"]);
    $street = mysqli_real_escape_string($conn, $_POST["street"]);
    $birthDate = mysqli_real_escape_string($conn, $_POST["birthDate"]);
    $birthPlace = mysqli_real_escape_string($conn, $_POST["birthPlace"]);
    $maritalStatus = mysqli_real_escape_string($conn, $_POST["maritalStatus"]);
    $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
    $contactNumber = mysqli_real_escape_string($conn, $_POST["contactNumber"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $religion = mysqli_real_escape_string($conn, $_POST["religion"]);
    $ethnic = mysqli_real_escape_string($conn, $_POST["ethnic"]);
    $language = mysqli_real_escape_string($conn, $_POST["language"]);
    $oscaID = mysqli_real_escape_string($conn, $_POST["oscaID"]);
    $sss = mysqli_real_escape_string($conn, $_POST["sss"]);
    $tin = mysqli_real_escape_string($conn, $_POST["tin"]);
    $philhealth = mysqli_real_escape_string($conn, $_POST["philhealth"]);
    $orgID = mysqli_real_escape_string($conn, $_POST["orgID"]);
    $govID = mysqli_real_escape_string($conn, $_POST["govID"]);
    $travel = isset($_POST["travel"]) ? mysqli_real_escape_string($conn, $_POST["travel"]) : '';
    $serviceEmp = mysqli_real_escape_string($conn, $_POST["serviceEmp"]);
    $pension = mysqli_real_escape_string($conn, $_POST["pension"]);
    $spouseLastName = mysqli_real_escape_string($conn, $_POST["spouseLastName"]);
    $spouseFirstName = mysqli_real_escape_string($conn, $_POST["spouseFirstName"]);
    $spouseMiddleName = mysqli_real_escape_string($conn, $_POST["spouseMiddleName"]);
    $spouseExtensionName = mysqli_real_escape_string($conn, $_POST["spouseExtensionName"]);
    $fatherLastName = mysqli_real_escape_string($conn, $_POST["fatherLastName"]);
    $fatherFirstName = mysqli_real_escape_string($conn, $_POST["fatherFirstName"]);
    $fatherMiddleName = mysqli_real_escape_string($conn, $_POST["fatherMiddleName"]);
    $fatherExtensionName = mysqli_real_escape_string($conn, $_POST["fatherExtensionName"]);
    $motherLastName = mysqli_real_escape_string($conn, $_POST["motherLastName"]);
    $motherFirstName = mysqli_real_escape_string($conn, $_POST["motherFirstName"]);
    $motherMiddleName = mysqli_real_escape_string($conn, $_POST["motherMiddleName"]);
    $child1FullName = mysqli_real_escape_string($conn, $_POST["child1FullName"]);
    $child1Occupation = mysqli_real_escape_string($conn, $_POST["child1Occupation"]);
    $child1Income = mysqli_real_escape_string($conn, $_POST["child1Income"]);
    $child1Age = mysqli_real_escape_string($conn, $_POST["child1Age"]);
    $child1Work = mysqli_real_escape_string($conn, $_POST["child1Work"]);
    $child2FullName = mysqli_real_escape_string($conn, $_POST["child2FullName"]);
    $child2Occupation = mysqli_real_escape_string($conn, $_POST["child2Occupation"]);
    $child2Income = mysqli_real_escape_string($conn, $_POST["child2Income"]);
    $child2Age = mysqli_real_escape_string($conn, $_POST["child2Age"]);
    $child2Work = mysqli_real_escape_string($conn, $_POST["child2Work"]);
    $child3FullName = mysqli_real_escape_string($conn, $_POST["child3FullName"]);
    $child3Occupation = mysqli_real_escape_string($conn, $_POST["child3Occupation"]);
    $child3Income = mysqli_real_escape_string($conn, $_POST["child3Income"]);
    $child3Age = mysqli_real_escape_string($conn, $_POST["child3Age"]);
    $child3Work = mysqli_real_escape_string($conn, $_POST["child3Work"]);
    $child4FullName = mysqli_real_escape_string($conn, $_POST["child4FullName"]);
    $child4Occupation = mysqli_real_escape_string($conn, $_POST["child4Occupation"]);
    $child4Income = mysqli_real_escape_string($conn, $_POST["child4Income"]);
    $child4Age = mysqli_real_escape_string($conn, $_POST["child4Age"]);
    $child4Work = mysqli_real_escape_string($conn, $_POST["child4Work"]);
    $dependentFullName = mysqli_real_escape_string($conn, $_POST["dependentFullName"]);
    $dependentOccupation = mysqli_real_escape_string($conn, $_POST["dependentOccupation"]);
    $dependentIncome = mysqli_real_escape_string($conn, $_POST["dependentIncome"]);
    $dependentAge = mysqli_real_escape_string($conn, $_POST["dependentAge"]);
    $dependentWork = mysqli_real_escape_string($conn, $_POST["dependentWork"]);
    $dependent2FullName = mysqli_real_escape_string($conn, $_POST["dependent2FullName"]);
    $dependent2Occupation = mysqli_real_escape_string($conn, $_POST["dependent2Occupation"]);
    $dependent2Income = mysqli_real_escape_string($conn, $_POST["dependent2Income"]);
    $dependent2Age = mysqli_real_escape_string($conn, $_POST["dependent2Age"]);
    $dependent2Work = mysqli_real_escape_string($conn, $_POST["dependent2Work"]);
    $dependent3FullName = mysqli_real_escape_string($conn, $_POST["dependent3FullName"]);
    $dependent3Occupation = mysqli_real_escape_string($conn, $_POST["dependent3Occupation"]);
    $dependent3Income = mysqli_real_escape_string($conn, $_POST["dependent3Income"]);
    $dependent3Age = mysqli_real_escape_string($conn, $_POST["dependent3Age"]);
    $dependent3Work = mysqli_real_escape_string($conn, $_POST["dependent3Work"]);
    $educationalAttainment = mysqli_real_escape_string($conn, $_POST["educationalAttainment"]);
    $specialization = isset($_POST['specialization']) ? $_POST['specialization'] : array();
    $specializationData=implode(",",$specialization);
    if (empty($specialization)) {
        $specializationData = '';
    } else {
        $specializationData = implode(",", $specialization);
    }
    $specializationOthers = mysqli_real_escape_string($conn, $_POST["specializationOthers"]);
    $shareSkill = mysqli_real_escape_string($conn, $_POST["shareSkill"]);
    $shareSkill1 = mysqli_real_escape_string($conn, $_POST["shareSkill1"]);
    $shareSkill2 = mysqli_real_escape_string($conn, $_POST["shareSkill2"]);
    $communityService = isset($_POST['communityService']) ? $_POST['communityService'] : array();
    $communityServiceData=implode(",",$communityService);
    if (empty($communityService)) {
        $communityServiceData = '';
    } else {
        $communityServiceData = implode(",", $communityService);
    }
    $communityServiceOthers = mysqli_real_escape_string($conn, $_POST["communityServiceOthers"]);

    $residingwith = isset($_POST['residingwith']) ? $_POST['residingwith'] : array();
    $residingwithData=implode(",",$residingwith);
    if (empty($residingwith)) {
        $residingwithData = '';
    } else {
        $residingwithData = implode(",", $residingwith);
    }
    
    $residingWithOthers = mysqli_real_escape_string($conn, $_POST["residingWithOthers"]);

   $houseHold = isset($_POST['houseHold']) ? $_POST['houseHold'] : array();
    $houseHoldData=implode(",",$houseHold);
    if (empty($houseHold)) {
        $houseHoldData = '';
    } else {
        $houseHoldData = implode(",", $houseHold);
    }

    $houseHoldOthers = mysqli_real_escape_string($conn, $_POST["houseHoldOthers"]);

    $sourceIncome = isset($_POST['sourceIncome']) ? $_POST['sourceIncome'] : array();
    $sourceIncomeData=implode(",",$sourceIncome);
    if (empty($sourceIncome)) {
        $sourceIncomeData = '';
    } else {
        $sourceIncomeData = implode(",", $sourceIncome);
    }
    $sourceIncomeOthers = mysqli_real_escape_string($conn, $_POST["sourceIncomeOthers"]);
    $assetsFirst = isset($_POST['assetsFirst']) ? $_POST['assetsFirst'] : array();
    $assetsFirstData=implode(",",$assetsFirst);
    if (empty($assetsFirst)) {
        $assetsFirstData = '';
    } else {
        $assetsFirstData = implode(",", $assetsFirst);
    }    
    $assetsFirstOthers = mysqli_real_escape_string($conn, $_POST["assetsFirstOthers"]);
    $assetsSecond = isset($_POST['assetsSecond']) ? $_POST['assetsSecond'] : array();
    $assetsSecondData=implode(",",$assetsSecond);
    if (empty($assetsSecond)) {
        $assetsSecondData = '';
    } else {
        $assetsSecondData = implode(",", $assetsSecond);
    }    
    $assetsSecondOthers = mysqli_real_escape_string($conn, $_POST["assetsSecondOthers"]);
    $monthlyIncome = isset($_POST["monthlyIncome"]) ? mysqli_real_escape_string($conn, $_POST["monthlyIncome"]) : '';
    $incomeOthers = isset($_POST["incomeOthers"]) ? mysqli_real_escape_string($conn, $_POST["incomeOthers"]) : '';
    $problems = isset($_POST['problems']) ? $_POST['problems'] : array();
    $problemsData=implode(",",$problems);
    if (empty($problems)) {
        $problemsData = '';
    } else {
        $problemsData = implode(",", $problems);
    }
    $problemsOthers = mysqli_real_escape_string($conn, $_POST["problemsOthers"]);
    $bloodType = mysqli_real_escape_string($conn, $_POST["bloodType"]);
    $physicalDisability = mysqli_real_escape_string($conn, $_POST["physicalDisability"]);
    $medicalConcern = isset($_POST['medicalConcern']) ? $_POST['medicalConcern'] : array();
    $medicalConcernData=implode(",",$medicalConcern);
    if (empty($medicalConcern)) {
        $medicalConcernData = '';
    } else {
        $medicalConcernData = implode(",", $medicalConcern);
    }    
    $medicalConcernOthers = mysqli_real_escape_string($conn, $_POST["medicalConcernOthers"]);
    $dentalConcern = mysqli_real_escape_string($conn, $_POST["dentalConcern"]);
    $dentalConcernOthers = mysqli_real_escape_string($conn, $_POST["dentalConcernOthers"]);
    $optical = isset($_POST['optical']) ? $_POST['optical'] : array();
    $opticalData=implode(",",$optical);
    if (empty($optical)) {
        $opticalData = '';
    } else {
        $opticalData = implode(",", $optical);
    }   
    $opticalOthers = mysqli_real_escape_string($conn, $_POST["opticalOthers"]);
    $hearing = mysqli_real_escape_string($conn, $_POST["hearing"]);
    $hearingOthers = mysqli_real_escape_string($conn, $_POST["hearingOthers"]);
    $socialEmotional = isset($_POST['socialEmotional']) ? $_POST['socialEmotional'] : array();
    $socialEmotionalData=implode(",",$socialEmotional);
    if (empty($socialEmotional)) {
        $socialEmotionalData = '';
    } else {
        $socialEmotionalData = implode(",", $socialEmotional);
    }   
    $socialEmotionalOthers = mysqli_real_escape_string($conn, $_POST["socialEmotionalOthers"]);
    $areaDifficulty = isset($_POST['areaDifficulty']) ? $_POST['areaDifficulty'] : array();
    $areaDifficultyData=implode(",",$areaDifficulty);
    if (empty($areaDifficulty)) {
        $areaDifficultyData = '';
    } else {
        $areaDifficultyData = implode(",", $areaDifficulty);
    }   
    $areaDifficultyOthers = mysqli_real_escape_string($conn, $_POST["areaDifficultyOthers"]);
    $medicines = mysqli_real_escape_string($conn, $_POST["medicines"]);
    $scheduledMedical = mysqli_real_escape_string($conn, $_POST["scheduledMedical"]);
    $scheduledMedical1 = mysqli_real_escape_string($conn, $_POST["scheduledMedical1"]);
    $scheduledMedical1Others = mysqli_real_escape_string($conn, $_POST["scheduledMedical1Others"]);
    
    


    $sqlInsert = "INSERT INTO people(rbiid ,referenceCode,imageup,lastName , firstName , middleName, extensionName,
    region,province,city,barangay,houseno,street,birthDate,birthPlace,maritalStatus,gender,contactNumber,
    email,religion,ethnic,language,oscaID,sss,tin,philhealth,orgID,govID,travel,serviceEmp,pension,
    spouseLastName,spouseFirstName,spouseMiddleName,spouseExtensionName,fatherLastName,fatherFirstName,
    fatherMiddleName,fatherExtensionName,motherLastName,motherFirstName,motherMiddleName,child1FullName,
    child1Occupation,child1Income,child1Age,child1Work,child2FullName,child2Occupation,child2Income,
    child2Age,child2Work,child3FullName,child3Occupation,child3Income,child3Age,child3Work,child4FullName,
    child4Occupation,child4Income,child4Age,child4Work,dependentFullName,dependentOccupation,dependentIncome,dependentAge,dependentWork
    ,dependent2FullName,dependent2Occupation,dependent2Income,dependent2Age,dependent2Work
    ,dependent3FullName,dependent3Occupation,dependent3Income,dependent3Age,dependent3Work,
    educationalAttainment,specialization,specializationOthers,shareSkill,shareSkill1,shareSkill2,communityService,communityServiceOthers,residingwith,
    residingWithOthers,houseHold,houseHoldOthers,sourceIncome,sourceIncomeOthers,assetsFirst,assetsFirstOthers,assetsSecond,assetsSecondOthers,
    monthlyIncome,incomeOthers,problems,problemsOthers,bloodType,physicalDisability,medicalConcern,medicalConcernOthers,dentalConcern,
    dentalConcernOthers,optical,opticalOthers,hearing,hearingOthers,socialEmotional,socialEmotionalOthers,
    areaDifficulty,areaDifficultyOthers,medicines,scheduledMedical,scheduledMedical1,scheduledMedical1Others)
    
    VALUES 

    ('$RBIID','$referenceCode','$targetFilePath','$lastName','$firstName', '$middleName','$extensionName','$region','$province','$city','$barangay','$houseno','$street',
    '$birthDate','$birthPlace','$maritalStatus','$gender','$contactNumber','$email','$religion','$ethnic','$language',
    '$oscaID','$sss','$tin','$philhealth','$orgID','$govID','$travel','$serviceEmp','$pension','$spouseLastName',
    '$spouseFirstName','$spouseMiddleName','$spouseExtensionName','$fatherLastName','$fatherFirstName',
    '$fatherMiddleName','$fatherExtensionName','$motherLastName','$motherFirstName','$motherMiddleName',
    '$child1FullName','$child1Occupation','$child1Income','$child1Age','$child1Work','$child2FullName',
    '$child2Occupation','$child2Income','$child2Age','$child2Work','$child3FullName','$child3Occupation',
    '$child3Income','$child3Age','$child3Work','$child4FullName','$child4Occupation','$child4Income',
    '$child4Age','$child4Work','$dependentFullName','$dependentOccupation','$dependentIncome','$dependentAge',
    '$dependentWork' ,'$dependent2FullName','$dependent2Occupation','$dependent2Income','$dependent2Age','$dependent2Work'
    ,'$dependent3FullName','$dependent3Occupation','$dependent3Income','$dependent3Age','$dependent3Work','$educationalAttainment','$specializationData',
    '$specializationOthers','$shareSkill','$shareSkill1','$shareSkill2','$communityServiceData','$communityServiceOthers',
    '$residingwithData','$residingWithOthers','$houseHoldData','$houseHoldOthers','$sourceIncomeData','$sourceIncomeOthers','$assetsFirstData','$assetsFirstOthers','$assetsSecondData',
    '$assetsSecondOthers','$monthlyIncome','$incomeOthers','$problemsData','$problemsOthers','$bloodType','$physicalDisability','$medicalConcernData','$medicalConcernOthers','$dentalConcern','$dentalConcernOthers','$opticalData','$opticalOthers',
    '$hearing','$hearingOthers','$socialEmotionalData','$socialEmotionalOthers','$areaDifficultyData','$areaDifficultyOthers','$medicines','$scheduledMedical','$scheduledMedical1','$scheduledMedical1Others')";

if(mysqli_query($conn,$sqlInsert)){
    $userName = mysqli_real_escape_string($conn, $_POST["user_name"]);
    $logMessage = "added a record for $lastName, $firstName";
    $logInsert = "INSERT INTO log (account, action) VALUES ('$userName', '$logMessage')";
    mysqli_query($conn, $logInsert);
    header("Location:success.php");
}else{
    die("Something went wrong");
}
}


if (isset($_POST["edit"])) {
    $id = $_POST["id"];
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $RBIID = mysqli_real_escape_string($conn, $_POST["rbiid"]);
    $lastName = mysqli_real_escape_string($conn, $_POST["lastName"]);
    $firstName = mysqli_real_escape_string($conn, $_POST["firstName"]);
    $middleName = mysqli_real_escape_string($conn, $_POST["middleName"]);
    $extensionName = mysqli_real_escape_string($conn, $_POST["extensionName"]);
    $region = mysqli_real_escape_string($conn, $_POST["region"]);
    $province = mysqli_real_escape_string($conn, $_POST["province"]);
    $city = mysqli_real_escape_string($conn, $_POST["city"]);
    $barangay = mysqli_real_escape_string($conn, $_POST["barangay"]);
    $houseno = mysqli_real_escape_string($conn, $_POST["houseno"]);
    $street = mysqli_real_escape_string($conn, $_POST["street"]);
    $birthDate = mysqli_real_escape_string($conn, $_POST["birthDate"]);
    $birthPlace = mysqli_real_escape_string($conn, $_POST["birthPlace"]);
    $maritalStatus = mysqli_real_escape_string($conn, $_POST["maritalStatus"]);
    $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
    $contactNumber = mysqli_real_escape_string($conn, $_POST["contactNumber"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $religion = mysqli_real_escape_string($conn, $_POST["religion"]);
    $ethnic = mysqli_real_escape_string($conn, $_POST["ethnic"]);
    $language = mysqli_real_escape_string($conn, $_POST["language"]);
    $oscaID = mysqli_real_escape_string($conn, $_POST["oscaID"]);
    $sss = mysqli_real_escape_string($conn, $_POST["sss"]);
    $tin = mysqli_real_escape_string($conn, $_POST["tin"]);
    $philhealth = mysqli_real_escape_string($conn, $_POST["philhealth"]);
    $orgID = mysqli_real_escape_string($conn, $_POST["orgID"]);
    $govID = mysqli_real_escape_string($conn, $_POST["govID"]);
    $travel = isset($_POST["travel"]) ? mysqli_real_escape_string($conn, $_POST["travel"]) : '';
    $serviceEmp = mysqli_real_escape_string($conn, $_POST["serviceEmp"]);
    $pension = mysqli_real_escape_string($conn, $_POST["pension"]);
    $spouseLastName = mysqli_real_escape_string($conn, $_POST["spouseLastName"]);
    $spouseFirstName = mysqli_real_escape_string($conn, $_POST["spouseFirstName"]);
    $spouseMiddleName = mysqli_real_escape_string($conn, $_POST["spouseMiddleName"]);
    $spouseExtensionName = mysqli_real_escape_string($conn, $_POST["spouseExtensionName"]);
    $fatherLastName = mysqli_real_escape_string($conn, $_POST["fatherLastName"]);
    $fatherFirstName = mysqli_real_escape_string($conn, $_POST["fatherFirstName"]);
    $fatherMiddleName = mysqli_real_escape_string($conn, $_POST["fatherMiddleName"]);
    $fatherExtensionName = mysqli_real_escape_string($conn, $_POST["fatherExtensionName"]);
    $motherLastName = mysqli_real_escape_string($conn, $_POST["motherLastName"]);
    $motherFirstName = mysqli_real_escape_string($conn, $_POST["motherFirstName"]);
    $motherMiddleName = mysqli_real_escape_string($conn, $_POST["motherMiddleName"]);
    $child1FullName = mysqli_real_escape_string($conn, $_POST["child1FullName"]);
    $child1Occupation = mysqli_real_escape_string($conn, $_POST["child1Occupation"]);
    $child1Income = mysqli_real_escape_string($conn, $_POST["child1Income"]);
    $child1Age = mysqli_real_escape_string($conn, $_POST["child1Age"]);
    $child1Work = mysqli_real_escape_string($conn, $_POST["child1Work"]);
    $child2FullName = mysqli_real_escape_string($conn, $_POST["child2FullName"]);
    $child2Occupation = mysqli_real_escape_string($conn, $_POST["child2Occupation"]);
    $child2Income = mysqli_real_escape_string($conn, $_POST["child2Income"]);
    $child2Age = mysqli_real_escape_string($conn, $_POST["child2Age"]);
    $child2Work = mysqli_real_escape_string($conn, $_POST["child2Work"]);
    $child3FullName = mysqli_real_escape_string($conn, $_POST["child3FullName"]);
    $child3Occupation = mysqli_real_escape_string($conn, $_POST["child3Occupation"]);
    $child3Income = mysqli_real_escape_string($conn, $_POST["child3Income"]);
    $child3Age = mysqli_real_escape_string($conn, $_POST["child3Age"]);
    $child3Work = mysqli_real_escape_string($conn, $_POST["child3Work"]);
    $child4FullName = mysqli_real_escape_string($conn, $_POST["child4FullName"]);
    $child4Occupation = mysqli_real_escape_string($conn, $_POST["child4Occupation"]);
    $child4Income = mysqli_real_escape_string($conn, $_POST["child4Income"]);
    $child4Age = mysqli_real_escape_string($conn, $_POST["child4Age"]);
    $child4Work = mysqli_real_escape_string($conn, $_POST["child4Work"]);
   /*
    $child5FullName = mysqli_real_escape_string($conn, $_POST["child5FullName"]);
    $child5Occupation = mysqli_real_escape_string($conn, $_POST["child5Occupation"]);
    $child5Income = mysqli_real_escape_string($conn, $_POST["child5Income"]);
    $child5Age = mysqli_real_escape_string($conn, $_POST["child5Age"]);
    $child5Work = mysqli_real_escape_string($conn, $_POST["child5Work"]);
    $child6FullName = mysqli_real_escape_string($conn, $_POST["child6FullName"]);
    $child6Occupation = mysqli_real_escape_string($conn, $_POST["child6Occupation"]);
    $child6Income = mysqli_real_escape_string($conn, $_POST["child6Income"]);
    $child6Age = mysqli_real_escape_string($conn, $_POST["child6Age"]);
    $child6Work = mysqli_real_escape_string($conn, $_POST["child6Work"]);
    $child7FullName = mysqli_real_escape_string($conn, $_POST["child7FullName"]);
    $child7Occupation = mysqli_real_escape_string($conn, $_POST["child7Occupation"]);
    $child7Income = mysqli_real_escape_string($conn, $_POST["child7Income"]);
    $child7Age = mysqli_real_escape_string($conn, $_POST["child7Age"]);
    $child7Work = mysqli_real_escape_string($conn, $_POST["child7Work"]);
    $child8FullName = mysqli_real_escape_string($conn, $_POST["child8FullName"]);
    $child8Occupation = mysqli_real_escape_string($conn, $_POST["child8Occupation"]);
    $child8Income = mysqli_real_escape_string($conn, $_POST["child8Income"]);
    $child8Age = mysqli_real_escape_string($conn, $_POST["child8Age"]);
    $child8Work = mysqli_real_escape_string($conn, $_POST["child8Work"]);
    $child9FullName = mysqli_real_escape_string($conn, $_POST["child9FullName"]);
    $child9Occupation = mysqli_real_escape_string($conn, $_POST["child9Occupation"]);
    $child9Income = mysqli_real_escape_string($conn, $_POST["child9Income"]);
    $child9Age = mysqli_real_escape_string($conn, $_POST["child9Age"]);
    $child9Work = mysqli_real_escape_string($conn, $_POST["child9Work"]);
    $child10FullName = mysqli_real_escape_string($conn, $_POST["child10FullName"]);
    $child10Occupation = mysqli_real_escape_string($conn, $_POST["child10Occupation"]);
    $child10Income = mysqli_real_escape_string($conn, $_POST["child10Income"]);
    $child10Age = mysqli_real_escape_string($conn, $_POST["child10Age"]);
    $child10Work = mysqli_real_escape_string($conn, $_POST["child10Work"]);
    */
    $dependentFullName = mysqli_real_escape_string($conn, $_POST["dependentFullName"]);
    $dependentOccupation = mysqli_real_escape_string($conn, $_POST["dependentOccupation"]);
    $dependentIncome = mysqli_real_escape_string($conn, $_POST["dependentIncome"]);
    $dependentAge = mysqli_real_escape_string($conn, $_POST["dependentAge"]);
    $dependentWork = mysqli_real_escape_string($conn, $_POST["dependentWork"]);
    $dependent2FullName = mysqli_real_escape_string($conn, $_POST["dependent2FullName"]);
    $dependent2Occupation = mysqli_real_escape_string($conn, $_POST["dependent2Occupation"]);
    $dependent2Income = mysqli_real_escape_string($conn, $_POST["dependent2Income"]);
    $dependent2Age = mysqli_real_escape_string($conn, $_POST["dependent2Age"]);
    $dependent2Work = mysqli_real_escape_string($conn, $_POST["dependent2Work"]);
    $dependent3FullName = mysqli_real_escape_string($conn, $_POST["dependent3FullName"]);
    $dependent3Occupation = mysqli_real_escape_string($conn, $_POST["dependent3Occupation"]);
    $dependent3Income = mysqli_real_escape_string($conn, $_POST["dependent3Income"]);
    $dependent3Age = mysqli_real_escape_string($conn, $_POST["dependent3Age"]);
    $dependent3Work = mysqli_real_escape_string($conn, $_POST["dependent3Work"]);
   /*
    $dependent4FullName = mysqli_real_escape_string($conn, $_POST["dependent4FullName"]);
    $dependent4Occupation = mysqli_real_escape_string($conn, $_POST["dependent4Occupation"]);
    $dependent4Income = mysqli_real_escape_string($conn, $_POST["dependent4Income"]);
    $dependent4Age = mysqli_real_escape_string($conn, $_POST["dependent4Age"]);
    $dependent4Work = mysqli_real_escape_string($conn, $_POST["dependent4Work"]);
    $dependent5FullName = mysqli_real_escape_string($conn, $_POST["dependent5FullName"]);
    $dependent5Occupation = mysqli_real_escape_string($conn, $_POST["dependent5Occupation"]);
    $dependent5Income = mysqli_real_escape_string($conn, $_POST["dependent5Income"]);
    $dependent5Age = mysqli_real_escape_string($conn, $_POST["dependent5Age"]);
    $dependent5Work = mysqli_real_escape_string($conn, $_POST["dependent5Work"]);
    */
    $educationalAttainment = mysqli_real_escape_string($conn, $_POST["educationalAttainment"]);
    $specialization = isset($_POST['specialization']) ? $_POST['specialization'] : array();
    $specializationData=implode(",",$specialization);
    if (empty($specialization)) {
        $specializationData = '';
    } else {
        $specializationData = implode(",", $specialization);
    }
    $specializationOthers = mysqli_real_escape_string($conn, $_POST["specializationOthers"]);
    $shareSkill = mysqli_real_escape_string($conn, $_POST["shareSkill"]);
    $shareSkill1 = mysqli_real_escape_string($conn, $_POST["shareSkill1"]);
    $shareSkill2 = mysqli_real_escape_string($conn, $_POST["shareSkill2"]);
    $communityService = isset($_POST['communityService']) ? $_POST['communityService'] : array();
    $communityServiceData=implode(",",$communityService);
    if (empty($communityService)) {
        $communityServiceData = '';
    } else {
        $communityServiceData = implode(",", $communityService);
    }
    $communityServiceOthers = mysqli_real_escape_string($conn, $_POST["communityServiceOthers"]);
    $residingwith = isset($_POST['residingwith']) ? $_POST['residingwith'] : array();
    $residingwithData=implode(",",$residingwith);
    if (empty($residingwith)) {
        $residingwithData = '';
    } else {
        $residingwithData = implode(",", $residingwith);
    }
    
    $residingWithOthers = mysqli_real_escape_string($conn, $_POST["residingWithOthers"]);
    $houseHold = isset($_POST['houseHold']) ? $_POST['houseHold'] : array();
    $houseHoldData=implode(",",$houseHold);
    if (empty($houseHold)) {
        $houseHoldData = '';
    } else {
        $houseHoldData = implode(",", $houseHold);
    }
    $houseHoldOthers = mysqli_real_escape_string($conn, $_POST["houseHoldOthers"]);
    $sourceIncome = isset($_POST['sourceIncome']) ? $_POST['sourceIncome'] : array();
    $sourceIncomeData=implode(",",$sourceIncome);
    if (empty($sourceIncome)) {
        $sourceIncomeData = '';
    } else {
        $sourceIncomeData = implode(",", $sourceIncome);
    }
    $sourceIncomeOthers = mysqli_real_escape_string($conn, $_POST["sourceIncomeOthers"]);
    $assetsFirst = isset($_POST['assetsFirst']) ? $_POST['assetsFirst'] : array();
    $assetsFirstData=implode(",",$assetsFirst);
    if (empty($assetsFirst)) {
        $assetsFirstData = '';
    } else {
        $assetsFirstData = implode(",", $assetsFirst);
    }    
    $assetsFirstOthers = mysqli_real_escape_string($conn, $_POST["assetsFirstOthers"]);
    $assetsSecond = isset($_POST['assetsSecond']) ? $_POST['assetsSecond'] : array();
    $assetsSecondData=implode(",",$assetsSecond);
    if (empty($assetsSecond)) {
        $assetsSecondData = '';
    } else {
        $assetsSecondData = implode(",", $assetsSecond);
    }    
    $assetsSecondOthers = mysqli_real_escape_string($conn, $_POST["assetsSecondOthers"]);
    $monthlyIncome = isset($_POST["monthlyIncome"]) ? mysqli_real_escape_string($conn, $_POST["monthlyIncome"]) : '';
    $incomeOthers = isset($_POST["incomeOthers"]) ? mysqli_real_escape_string($conn, $_POST["incomeOthers"]) : '';
    $problems = isset($_POST['problems']) ? $_POST['problems'] : array();
    $problemsData=implode(",",$problems);
    if (empty($problems)) {
        $problemsData = '';
    } else {
        $problemsData = implode(",", $problems);
    }
    $problemsOthers = mysqli_real_escape_string($conn, $_POST["problemsOthers"]);
    $bloodType = mysqli_real_escape_string($conn, $_POST["bloodType"]);
    $physicalDisability = mysqli_real_escape_string($conn, $_POST["physicalDisability"]);
    $medicalConcern = isset($_POST['medicalConcern']) ? $_POST['medicalConcern'] : array();
    $medicalConcernData=implode(",",$medicalConcern);
    if (empty($medicalConcern)) {
        $medicalConcernData = '';
    } else {
        $medicalConcernData = implode(",", $medicalConcern);
    }    
    $medicalConcernOthers = mysqli_real_escape_string($conn, $_POST["medicalConcernOthers"]);
    $dentalConcern = mysqli_real_escape_string($conn, $_POST["dentalConcern"]);
    $dentalConcernOthers = mysqli_real_escape_string($conn, $_POST["dentalConcernOthers"]);
    $optical = isset($_POST['optical']) ? $_POST['optical'] : array();
    $opticalData=implode(",",$optical);
    if (empty($optical)) {
        $opticalData = '';
    } else {
        $opticalData = implode(",", $optical);
    }  
    $opticalOthers = mysqli_real_escape_string($conn, $_POST["opticalOthers"]);
    $hearing = mysqli_real_escape_string($conn, $_POST["hearing"]);
    $hearingOthers = mysqli_real_escape_string($conn, $_POST["hearingOthers"]);
    $socialEmotional = isset($_POST['socialEmotional']) ? $_POST['socialEmotional'] : array();
    $socialEmotionalData=implode(",",$socialEmotional);
    if (empty($socialEmotional)) {
        $socialEmotionalData = '';
    } else {
        $socialEmotionalData = implode(",", $socialEmotional);
    }  
    $socialEmotionalOthers = mysqli_real_escape_string($conn, $_POST["socialEmotionalOthers"]);
    $areaDifficulty = isset($_POST['areaDifficulty']) ? $_POST['areaDifficulty'] : array();
    $areaDifficultyData=implode(",",$areaDifficulty);
    if (empty($areaDifficulty)) {
        $areaDifficultyData = '';
    } else {
        $areaDifficultyData = implode(",", $areaDifficulty);
    } 
    $areaDifficultyOthers = mysqli_real_escape_string($conn, $_POST["areaDifficultyOthers"]);
    $medicines = mysqli_real_escape_string($conn, $_POST["medicines"]);
    $scheduledMedical = mysqli_real_escape_string($conn, $_POST["scheduledMedical"]);
    $scheduledMedical1 = mysqli_real_escape_string($conn, $_POST["scheduledMedical1"]);
    $scheduledMedical1Others = mysqli_real_escape_string($conn, $_POST["scheduledMedical1Others"]);
    $personStatus = mysqli_real_escape_string($conn, $_POST["personStatus"]);

    
   $sqlUpdate = "UPDATE people SET
    rbiid = '$RBIID',
    lastName = '$lastName',
    firstName = '$firstName',
    gender = '$gender',
    middleName = '$middleName',
    extensionName = '$extensionName',
    region = '$region',
    province = '$province',
    city = '$city',
    barangay = '$barangay',
    houseno = '$houseno',
    street = '$street',
    birthDate = '$birthDate',
    birthPlace = '$birthPlace',
    maritalStatus = '$maritalStatus',
    gender = '$gender',
    contactNumber = '$contactNumber',
    email = '$email',
    religion = '$religion',
    ethnic = '$ethnic',
    language = '$language',
    oscaID = '$oscaID',
    sss = '$sss',
    tin = '$tin',
    philhealth = '$philhealth',
    orgID = '$orgID',
    govID = '$govID',
    travel = '$travel',
    serviceEmp = '$serviceEmp',
    pension = '$pension',
    spouseLastName = '$spouseLastName',
    spouseFirstName = '$spouseFirstName',
    spouseMiddleName = '$spouseMiddleName',
    spouseExtensionName = '$spouseExtensionName',
    fatherLastName = '$fatherLastName',
    fatherFirstName = '$fatherFirstName',
    fatherMiddleName = '$fatherMiddleName',
    fatherExtensionName = '$fatherExtensionName',
    motherLastName = '$motherLastName',
    motherFirstName = '$motherFirstName',
    motherMiddleName = '$motherMiddleName',
    child1FullName = '$child1FullName',
    child1FullName = '$child1FullName',
    child1Occupation = '$child1Occupation',
    child1Income = '$child1Income',
    child1Age = '$child1Age', 
    child1Work = '$child1Work', 
    child2FullName = '$child2FullName', 
    child2Occupation = '$child2Occupation', 
    child2Income = '$child2Income', 
    child2Age = '$child2Age', 
    child2Work = '$child2Work', 
    child3FullName = '$child3FullName', 
    child3Occupation = '$child3Occupation', 
    child3Income = '$child3Income', 
    child3Age = '$child3Age', 
    child3Work = '$child3Work', 
    child4FullName = '$child4FullName', 
    child4Occupation = '$child4Occupation', 
    child4Income = '$child4Income', 
    child4Age = '$child4Age', 
    child4Work = '$child4Work', 
    dependentFullName = '$dependentFullName', 
    dependentOccupation = '$dependentOccupation', 
    dependentIncome = '$dependentIncome', 
    dependentAge = '$dependentAge', 
    dependentWork = '$dependentWork', 
    dependent2FullName = '$dependent2FullName', 
    dependent2Occupation = '$dependent2Occupation', 
    dependent2Income = '$dependent2Income', 
    dependent2Age = '$dependent2Age', 
    dependent2Work = '$dependent2Work', 
    dependent3FullName = '$dependent3FullName', 
    dependent3Occupation = '$dependent3Occupation', 
    dependent3Income = '$dependent3Income', 
    dependent3Age = '$dependent3Age', 
    dependent3Work = '$dependent3Work', 
    educationalAttainment = '$educationalAttainment', 
    specialization = '$specializationData',
    specializationOthers = '$specializationOthers',
    shareSkill = '$shareSkill', 
    shareSkill1 = '$shareSkill1',
    shareSkill2 = '$shareSkill2',
    communityService = '$communityServiceData',
    communityServiceOthers = '$communityServiceOthers',
    residingwith = '$residingwithData',
    residingWithOthers = '$residingWithOthers', 
    houseHold = '$houseHoldData',
    houseHoldOthers = '$houseHoldOthers', 
    sourceIncome = '$sourceIncomeData',
    sourceIncomeOthers = '$sourceIncomeOthers', 
    assetsFirst = '$assetsFirstData',
    assetsFirstOthers = '$assetsFirstOthers', 
    assetsSecond = '$assetsSecondData',
    assetsSecondOthers = '$assetsSecondOthers', 
    monthlyIncome = '$monthlyIncome', 
    incomeOthers = '$incomeOthers', 
    problems = '$problemsData',
    problemsOthers = '$problemsOthers',
    bloodType = '$bloodType', 
    medicalConcern = '$medicalConcernData',
    medicalConcernOthers = '$medicalConcernOthers',
    physicalDisability = '$physicalDisability', 
    dentalConcern = '$dentalConcern',
    dentalConcernOthers = '$dentalConcernOthers',
    optical = '$opticalData',
    opticalOthers = '$opticalOthers', 
    hearing = '$hearing', 
    hearingOthers = '$hearingOthers', 
    socialEmotional = '$socialEmotionalData',
    socialEmotionalOthers = '$socialEmotionalOthers',
    areaDifficulty = '$areaDifficultyData', 
    areaDifficultyOthers = '$areaDifficultyOthers', 
    medicines = '$medicines', 
    scheduledMedical = '$scheduledMedical', 
    scheduledMedical1 = '$scheduledMedical1',
    scheduledMedical1Others = '$scheduledMedical1Others',
    personStatus = '$personStatus'
    ";
if ($_FILES["imageup"]["name"]) {
    $imageup = $_FILES['imageup']['name'];
    $targetDirectory = "imageuploaded/"; 
    $targetFilePath = $targetDirectory . basename($_FILES["imageup"]["name"]);
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    move_uploaded_file($_FILES["imageup"]["tmp_name"], $targetFilePath);
    $sqlUpdate .= ", imageup='$targetFilePath'";
}

if ($_FILES["deceasedCert"]["name"]) {
    $uploadImage1 = $_FILES['deceasedCert']['name'];
    $targetDirectory1 = "deceasedImg/"; // Directory to upload the image
    $targetFilePath1 = $targetDirectory1 . basename($_FILES["deceasedCert"]["name"]);
    $fileType1 = pathinfo($targetFilePath1, PATHINFO_EXTENSION);
    move_uploaded_file($_FILES["deceasedCert"]["tmp_name"], $targetFilePath1);
    $sqlUpdate .= ", deceasedCert='$targetFilePath1'";
}

if (isset($_POST["personStatus"]) && $_POST["personStatus"] == "Deceased") {
    $currentDate = date("Y-m-d");
    $sqlUpdate .= ", date_deceased='$currentDate'";
}

$sqlUpdate .= " WHERE id='$id'";

if (mysqli_query($conn, $sqlUpdate)) {
    $userName = mysqli_real_escape_string($conn, $_POST["user_name"]);
    $logMessage = "updated a record for $lastName, $firstName";
    $logInsert = "INSERT INTO log (account, action) VALUES ('$userName', '$logMessage')";
    mysqli_query($conn, $logInsert);
    header("Location: view.php?id=$id");
} else {
    die("Something went wrong");
}
} else {
    header("Location: success.php");
}

?>