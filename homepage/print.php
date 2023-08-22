<?php
include('../configuration/config.php');

$id = isset($_GET['id']) ? $_GET['id'] : null;
if ($id) {
    $sql = "SELECT * FROM people WHERE id = $id";
    $result = mysqli_query($conx, $sql);
    $row = mysqli_fetch_assoc($result);
    
    $RBIID = $row['RBIID'];
    $referenceCode = $row['referenceCode'];
    $lastName = $row['lastName'];
    $firstName = $row['firstName'];
    $middleName = $row['middleName'];
    $extensionName = $row['extensionName'];
    $region = $row['region'];
    $province = $row['province'];
    $city = $row['city'];
    $barangay = $row['barangay'];
    $houseno = $row['houseno'];
    $street = $row['street'];
    $birthDate = $row['birthDate'];
    $birthPlace = $row['birthPlace'];
    $maritalStatus = $row['maritalStatus'];
    $gender = $row['gender'];
    $contactNumber = $row['contactNumber'];
    $email = $row['email'];
    $religion = $row['religion'];
    $ethnic = $row['ethnic'];
    $language = $row['language'];
    $oscaID = $row['oscaID'];
    $sss = $row['sss'];
    $tin = $row['tin'];
    $philhealth = $row['philhealth'];
    $orgID = $row['orgID'];
    $govID = $row['govID'];
    $travel = $row['travel'];
    $serviceEmp = $row['serviceEmp'];
    $pension = $row['pension'];
    $spouseLastName = $row['spouseLastName'];
    $spouseFirstName = $row['spouseFirstName'];
    $spouseMiddleName = $row['spouseMiddleName'];
    $spouseExtensionName = $row['spouseExtensionName'];
    $fatherLastName = $row['fatherLastName'];
    $fatherFirstName = $row['fatherFirstName'];
    $fatherMiddleName = $row['fatherMiddleName'];
    $fatherExtensionName = $row['fatherExtensionName'];
    $motherLastName = $row['motherLastName'];
    $motherFirstName = $row['motherFirstName'];
    $motherMiddleName = $row['motherMiddleName'];
    $child1FullName = $row['child1FullName'];
    $child1Occupation = $row['child1Occupation'];
    $child1Income = $row['child1Income'];
    $child1Age = $row['child1Age'];
    $child1Work = $row['child1Work'];
    $child2FullName = $row['child2FullName'];
    $child2Occupation = $row['child2Occupation'];
    $child2Income = $row['child2Income'];
    $child2Age = $row['child2Age'];
    $child2Work = $row['child2Work'];
    $child3FullName = $row['child3FullName'];
    $child3Occupation = $row['child3Occupation'];
    $child3Income = $row['child3Income'];
    $child3Age = $row['child3Age'];
    $child3Work = $row['child3Work'];
    $child4FullName = $row['child4FullName'];
    $child4Occupation = $row['child4Occupation'];
    $child4Income = $row['child4Income'];
    $child4Age = $row['child4Age'];
    $child4Work = $row['child4Work'];
    $dependentFullName = $row['dependentFullName'];
    $dependentOccupation = $row['dependentOccupation'];
    $dependentIncome = $row['dependentIncome'];
    $dependentAge = $row['dependentAge'];
    $dependentWork = $row['dependentWork'];
    $dependent2FullName = $row['dependent2FullName'];
    $dependent2Occupation = $row['dependent2Occupation'];
    $dependent2Income = $row['dependent2Income'];
    $dependent2Age = $row['dependent2Age'];
    $dependent2Work = $row['dependent2Work'];
    $dependent3FullName = $row['dependent3FullName'];
    $dependent3Occupation = $row['dependent3Occupation'];
    $dependent3Income = $row['dependent3Income'];
    $dependent3Age = $row['dependent3Age'];
    $dependent3Work = $row['dependent3Work'];
    $educationalAttainment = $row['educationalAttainment'];
    $specialization = $row['specialization'];
    $specializationOthers = $row['specializationOthers'];
    $shareSkill = $row['shareSkill'];
    $shareSkill1 = $row['shareSkill1'];
    $shareSkill2 = $row['shareSkill2'];
    $communityService = $row['communityService'];
    $communityServiceOthers = $row['communityServiceOthers'];
    $residingwith = $row['residingwith'];
    $residingWithOthers = $row['residingWithOthers'];
    $houseHold = $row['houseHold'];
    $houseHoldOthers = $row['houseHoldOthers'];
    $sourceIncome = $row['sourceIncome'];
    $sourceIncomeOthers = $row['sourceIncomeOthers'];
    $assetsFirst = $row['assetsFirst'];
    $assetsFirstOthers = $row['assetsFirstOthers'];
    $assetsSecond = $row['assetsSecond'];
    $assetsSecondOthers = $row['assetsSecondOthers'];
    $monthlyIncome = $row['monthlyIncome'];
    $problems = $row['problems'];
    $problemsOthers = $row['problemsOthers'];
    $bloodType = $row['bloodType'];
    $physicalDisability = $row['physicalDisability'];
    $medicalConcern = $row['medicalConcern'];
    $medicalConcernOthers = $row['medicalConcernOthers'];
    $dentalConcern = $row['dentalConcern'];
    $dentalConcernOthers = $row['dentalConcernOthers'];
    $optical = $row['optical'];
    $opticalOthers = $row['opticalOthers'];
    $hearing = $row['hearing'];
    $hearingOthers = $row['hearingOthers'];
    $socialEmotional = $row['socialEmotional'];
    $socialEmotionalOthers = $row['socialEmotionalOthers'];
    $areaDifficulty = $row['areaDifficulty'];
    $areaDifficultyOthers = $row['areaDifficultyOthers'];
    $scheduledMedical = $row['scheduledMedical'];
    $scheduledMedical1 = $row['scheduledMedical1'];
    $scheduledMedical1Others = $row['scheduledMedical1Others'];

    $medicines = $row['medicines'];


    $medicinesArray = explode(',', $medicines);
    for ($i = 0; $i < 12; $i++) {
        if (isset($medicinesArray[$i])) {
            ${'medicine' . ($i + 1)} = trim($medicinesArray[$i]);
        } else {
            ${'medicine' . ($i + 1)} = ''; 
        }
    }

    if (strpos($birthDate, '-') !== false) {
        // Format is yyyy-mm-dd or mm-dd-yyyy
        $dateArray = preg_split('/[-\/]/', $birthDate);
        if (strlen($dateArray[0]) === 4) {
            // yyyy-mm-dd format
            $year = substr($dateArray[0], -2);
            $month = $dateArray[1];
            $day = $dateArray[2];
        } else {
            // mm-dd-yyyy format
            $year = substr($dateArray[2], -2);
            $month = $dateArray[0];
            $day = $dateArray[1];
        }
    } else {
        // Format is mm/dd/yyyy
        list($month, $day, $year) = explode('/', $birthDate);
        $year = substr($year, -2);
    }
    
    // Convert to mdy format without spacing
    $mdyFormat = sprintf('%02d%02d%02d', $month, $day, $year);

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="printstyle.css?v=<?php echo time(); ?>" />
    <meta charset="UTF-8" />
    <title>Print | <?php echo $row["firstName"]; ?></title>
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="../img/sslogo.png">
</head>

<body>

    <div class="printimg">
        <div class="firstWholePage">
            <div class="page">
                <div class="image-container">
                    <div class="userimage">
                        <?php if ($row['imageup'] && $row['imageup'] !== 'imageuploaded/') : ?>
                        <img src="<?php echo $row['imageup']; ?>" class="uploaded-image">
                        <?php else: ?>
                        <p class="no-image"></p>
                        <?php endif; ?>
                    </div>
                </div>
                <img class="img1" src="images/pg01.jpg" alt="">
                <div class="inputs">
                    <div class="firstPage">

                        <p class="referenceCode"><?php echo $referenceCode; ?></p>
                        <p class="lastName"><?php echo $lastName; ?></p>
                        <p class="firstName"><?php echo $firstName; ?></p>
                        <p class="middleName"><?php echo $middleName; ?></p>
                        <p class="extensionName"><?php echo $extensionName; ?></p>
                        <p class="region"><?php echo $region; ?></p>
                        <p class="province"><?php echo $province; ?></p>
                        <p class="city"><?php echo $city; ?></p>
                        <p class="barangay"><?php echo $barangay; ?></p>
                        <p class="houseno"><?php echo $houseno; ?></p>
                        <p class="street"><?php echo $street; ?></p>
                        <p class="birthDate"><?php echo $mdyFormat; ?></p>
                        <p class="birthPlace"><?php echo $birthPlace; ?></p>
                        <p class="maritalStatus"><?php echo $maritalStatus; ?></p>
                        <p class="gender"><?php echo $gender; ?></p>
                        <p class="contactNumber"><?php echo $contactNumber; ?></p>
                        <p class="email"><?php echo $email; ?></p>
                        <p class="religion"><?php echo $religion; ?></p>
                        <p class="ethnic"><?php echo $ethnic; ?></p>
                        <p class="language"><?php echo $language; ?></p>
                        <p class="oscaID"><?php echo $oscaID; ?></p>
                        <p class="sss"><?php echo $sss; ?></p>
                        <p class="tin"><?php echo $tin; ?></p>
                        <p class="philhealth"><?php echo $philhealth; ?></p>
                        <p class="orgID"><?php echo $orgID; ?></p>
                        <p class="govID"><?php echo $govID; ?></p>

                        <?php
$travelOptions = explode(',', $row['travel']);

$displayText = "";

foreach ($travelOptions as $option) {
    $trimmedOption = trim($option);

    switch ($trimmedOption) {
        case 'Yes':
            $displayText .= '<span class="travelYes">✔</span>';
            break;
        case 'No':
            $displayText .= '<span class="travelNo">✔</span>';
            break;
    }
}
echo $displayText;
?>
                        <p class="serviceEmp"><?php echo $serviceEmp; ?></p>
                        <p class="pension"><?php echo $pension; ?></p>
                        <p class="spouseLastName"><?php echo $spouseLastName; ?></p>
                        <p class="spouseFirstName"><?php echo $spouseFirstName; ?></p>
                        <p class="spouseMiddleName"><?php echo $spouseMiddleName; ?></p>
                        <p class="spouseExtensionName"><?php echo $spouseExtensionName; ?></p>
                        <p class="fatherLastName"><?php echo $fatherLastName; ?></p>
                        <p class="fatherFirstName"><?php echo $fatherFirstName; ?></p>
                        <p class="fatherMiddleName"><?php echo $fatherMiddleName; ?></p>
                        <p class="fatherExtensionName"><?php echo $fatherExtensionName; ?></p>
                        <p class="motherLastName"><?php echo $motherLastName; ?></p>
                        <p class="motherFirstName"><?php echo $motherFirstName; ?></p>
                        <p class="motherMiddleName"><?php echo $motherMiddleName; ?></p>
                        <p class="child1FullName"><?php echo $child1FullName; ?></p>
                        <p class="child1Occupation"><?php echo $child1Occupation; ?></p>
                        <p class="child1Income"><?php echo $child1Income; ?></p>
                        <p class="child1Age"><?php echo $child1Age; ?></p>
                        <p class="child1Work"><?php echo $child1Work; ?></p>
                        <p class="child2FullName"><?php echo $child2FullName; ?></p>
                        <p class="child2Occupation"><?php echo $child2Occupation; ?></p>
                        <p class="child2Income"><?php echo $child2Income; ?></p>
                        <p class="child2Age"><?php echo $child2Age; ?></p>
                        <p class="child2Work"><?php echo $child2Work; ?></p>
                        <p class="child3FullName"><?php echo $child3FullName; ?></p>
                        <p class="child3Occupation"><?php echo $child3Occupation; ?></p>
                        <p class="child3Income"><?php echo $child3Income; ?></p>
                        <p class="child3Age"><?php echo $child3Age; ?></p>
                        <p class="child3Work"><?php echo $child3Work; ?></p>
                        <p class="child4FullName"><?php echo $child4FullName; ?></p>
                        <p class="child4Occupation"><?php echo $child4Occupation; ?></p>
                        <p class="child4Income"><?php echo $child4Income; ?></p>
                        <p class="child4Age"><?php echo $child4Age; ?></p>
                        <p class="child4Work"><?php echo $child4Work; ?></p>
                        <p class="dependentFullName"><?php echo $dependentFullName; ?></p>
                        <p class="dependentOccupation"><?php echo $dependentOccupation; ?></p>
                        <p class="dependentIncome"><?php echo $dependentIncome; ?></p>
                        <p class="dependentAge"><?php echo $dependentAge; ?></p>
                        <p class="dependentWork"><?php echo $dependentWork; ?></p>
                        <p class="dependent2FullName"><?php echo $dependent2FullName; ?></p>
                        <p class="dependent2Occupation"><?php echo $dependent2Occupation; ?></p>
                        <p class="dependent2Income"><?php echo $dependent2Income; ?></p>
                        <p class="dependent2Age"><?php echo $dependent2Age; ?></p>
                        <p class="dependent2Work"><?php echo $dependent2Work; ?></p>
                        <p class="dependent3FullName"><?php echo $dependent3FullName; ?></p>
                        <p class="dependent3Occupation"><?php echo $dependent3Occupation; ?></p>
                        <p class="dependent3Income"><?php echo $dependent3Income; ?></p>
                        <p class="dependent3Age"><?php echo $dependent3Age; ?></p>
                        <p class="dependent3Work"><?php echo $dependent3Work; ?></p>

                        <?php
  $educationalAttainment = trim($row['educationalAttainment']);

  switch ($educationalAttainment) {
      case 'College Graduate':
          $displayText = '<p class="collegeGrad">✔</p>';
          break;
      case 'Elementary Graduate':
          $displayText = '<p class="elemGrad">✔</p>';
          break;
      case 'High School Level':
          $displayText = '<p class="highSchoolLevel">✔</p>';
          break;
      case 'High School Graduate':
          $displayText = '<p class="highSchoolGrad">✔</p>';
          break;
      case 'College Level':
          $displayText = '<p class="collegeLevel">✔</p>';
          break;
      case 'Post Graduate':
          $displayText = '<p class="postGrad">✔</p>';
          break;
      case 'Vocational':
          $displayText = '<p class="vocational">✔</p>';
          break;
      case 'Elementary Level':
          $displayText = '<p class="elemLevel">✔</p>';
          break;
      case 'Not Attended School':
          $displayText = '<p class="notAttendedSchool">✔</p>';
          break;

  }
  
  echo $displayText;
  ?>

                        <?php
$specializations = explode(',', $row['specialization']);

$displayText = "";

foreach ($specializations as $specialization) {
    $trimmedSpecialization = trim($specialization);
    
    switch ($trimmedSpecialization) {
        case 'Medical':
            $displayText .= '<p class="specializationMedical">✔</p>';
            break;
        case 'Teaching':
            $displayText .= '<p class="specializationTeaching">✔</p>';
            break;
        case 'Legal Services':
            $displayText .= '<p class="specializationLegal">✔</p>';
            break;
        case 'Dental':
            $displayText .= '<p class="specializationDental">✔</p>';
            break;
        case 'Counseling':
            $displayText .= '<p class="specializationCounseling">✔</p>';
            break;
        case 'Farming':
            $displayText .= '<p class="specializationFarming">✔</p>';
            break;
        case 'Fishing':
            $displayText .= '<p class="specializationFishing">✔</p>';
            break;
        case 'Cooking':
            $displayText .= '<p class="specializationCooking">✔</p>';
            break;
        case 'Arts':
            $displayText .= '<p class="specializationArts">✔</p>';
            break;
        case 'Engineering':
            $displayText .= '<p class="specializationEngineering">✔</p>';
            break;
        case 'Carpenter':
            $displayText .= '<p class="specializationCarpenter">✔</p>';
            break;
        case 'Plumber':
            $displayText .= '<p class="specializationPlumber">✔</p>';
            break;
        case 'Barber':
            $displayText .= '<p class="specializationBarber">✔</p>';
            break;
        case 'Mason':
            $displayText .= '<p class="specializationMason">✔</p>';
            break;
        case 'Sapatero':
            $displayText .= '<p class="specializationSapatero">✔</p>';
            break;
        case 'Evangelization':
            $displayText .= '<p class="specializationEvangelization">✔</p>';
            break;
        case 'Tailor':
            $displayText .= '<p class="specializationTailor">✔</p>';
            break;
        case 'Chef / Cook':
            $displayText .= '<p class="specializationChef">✔</p>';
            break;
        case 'Milwright':
            $displayText .= '<p class="specializationMilwright">✔</p>';
            break;

    }
}
echo $displayText;
?>






                        <p class="specializationOthers"><?php echo $specializationOthers; ?></p>

                        <p class="shareSkill"><?php echo $shareSkill; ?></p>
                        <p class="shareSkill1"><?php echo $shareSkill1; ?></p>
                        <p class="shareSkill2"><?php echo $shareSkill2; ?></p>

                        <?php
$communityServices = explode(',', $communityService);

$displayText = "";

foreach ($communityServices as $service) {
    $trimmedService = trim($service);
    
    switch ($trimmedService) {
        case 'Medical':
            $displayText .= '<p class="communityServiceMedical">✔</p>';
            break;
        case 'Resource Volunteer':
            $displayText .= '<p class="communityServiceResource">✔</p>';
            break;
        case 'Community Beautification':
            $displayText .= '<p class="communityServiceBea">✔</p>';
            break;
        case 'Community / Organization Leader':
            $displayText .= '<p class="communityServiceOrg">✔</p>';
            break;
        case 'Dental':
            $displayText .= '<p class="communityServiceDental">✔</p>';
            break;
        case 'Friendly Visits':
            $displayText .= '<p class="communityServiceFri">✔</p>';
            break;
        case 'Neighborhood Support Services':
            $displayText .= '<p class="communityServiceNeigh">✔</p>';
            break;
        case 'Legal Services':
            $displayText .= '<p class="communityServiceLegal">✔</p>';
            break;
        case 'Religious':
            $displayText .= '<p class="communityServiceRel">✔</p>';
            break;
        case 'Counseling / Referral':
            $displayText .= '<p class="communityServiceCoun">✔</p>';
            break;
        case 'Sponsorship':
            $displayText .= '<p class="communityServiceSpo">✔</p>';
            break;
    }
}
echo $displayText;
?>

                        <p class="communityServiceOthers"><?php echo $communityServiceOthers; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="page">
            <img class="img2" src="images/page2.jpg" alt="">
            <div class="inputs2">
                <div class="secondPage">

                    <?php
$residintwiths = explode(',', $residingwith);

$displayText = "";

foreach ($residintwiths as $res) {
    $trimmedRes = trim($res);
    
    switch ($trimmedRes) {
        case 'Alone':
            $displayText .= '<p class="residingwithAlone">✔</p>';
            break;
        case 'Grand Child(ren)':
            $displayText .= '<p class="residingwithGrand">✔</p>';
            break;
        case 'Common Law Spouse':
            $displayText .= '<p class="residingwithCom">✔</p>';
            break;
        case 'Spouse':
            $displayText .= '<p class="residingwithSpouse">✔</p>';
            break;
        case 'In-law(s)':
            $displayText .= '<p class="residingwithInLaw">✔</p>';
            break;
        case 'Care Institution':
            $displayText .= '<p class="residingwithCare">✔</p>';
            break;
        case 'Child(ren)':
            $displayText .= '<p class="residingwithChild">✔</p>';
            break;
        case 'Relative(s)':
            $displayText .= '<p class="residingwithRel">✔</p>';
            break;
        case 'Friend(s)':
            $displayText .= '<p class="residingwithFri">✔</p>';
            break;
        default:
            break;
    }
}
echo $displayText;
?>


                    <p class="residingWithOthers"><?php echo $residingWithOthers; ?></p>

                    <?php
$houseHoldOptions = explode(',', $row['houseHold']);

$displayText = "";

foreach ($houseHoldOptions as $option) {
    $trimmedOption = trim($option);
    
    switch ($trimmedOption) {
        case 'No privacy':
            $displayText .= '<p class="houseHoldNoPrivacy">✔</p>';
            break;
        case 'Overcrowded in home':
            $displayText .= '<p class="houseHoldOver">✔</p>';
            break;
        case 'Informal Settler':
            $displayText .= '<p class="houseHoldInf">✔</p>';
            break;
        case 'No permanent house':
            $displayText .= '<p class="houseHoldNoPer">✔</p>';
            break;
        case 'High cost of rent':
            $displayText .= '<p class="houseHoldHigh">✔</p>';
            break;
        case 'Longing for independent living quiet atmosphere':
            $displayText .= '<p class="houseHoldLonging">✔</p>';
            break;
        default:
            break;
    }
}
echo $displayText;
?>
                    <p class="houseHoldOthers"><?php echo $houseHoldOthers; ?></p>

                    <?php
$sourceIncomeOptions = explode(',', $sourceIncome);

$displayText = "";

foreach ($sourceIncomeOptions as $option) {
    $trimmedOption = trim($option);

    switch ($trimmedOption) {
        case 'Own earnings of salary or Wages':
            $displayText .= '<p class="sourceIncomeOwn">✔</p>';
            break;
        case 'Own Pension':
            $displayText .= '<p class="sourceIncomeOwnPen">✔</p>';
            break;
        case 'Stocks / Dividends':
            $displayText .= '<p class="sourceIncomeStocks">✔</p>';
            break;
        case 'Dependent on children / relatives':
            $displayText .= '<p class="sourceIncomeDep">✔</p>';
            break;
        case 'Spouse salary':
            $displayText .= '<p class="sourceIncomeSpouseSal">✔</p>';
            break;
        case 'Insurance':
            $displayText .= '<p class="sourceIncomeIns">✔</p>';
            break;
        case 'Spouse Pension':
            $displayText .= '<p class="sourceIncomeSpousePen">✔</p>';
            break;
        case 'Rentals / sharecrops':
            $displayText .= '<p class="sourceIncomeRent">✔</p>';
            break;
        case 'Savings':
            $displayText .= '<p class="sourceIncomeSavings">✔</p>';
            break;
        case 'Livestock / orchard / farm':
            $displayText .= '<p class="sourceIncomeLive">✔</p>';
            break;
        case 'Fishing':
            $displayText .= '<p class="sourceIncomeFishing">✔</p>';
            break;
        default:
            break;
    }
}
echo $displayText;
?>
                    <p class="sourceIncomeOthers"><?php echo $sourceIncomeOthers; ?></p>

                    <?php
$assetsFirstOptions = explode(',', $assetsFirst);

$displayText = "";

foreach ($assetsFirstOptions as $option) {
    $trimmedOption = trim($option);

    switch ($trimmedOption) {
        case 'House':
            $displayText .= '<p class="assetsFirstHouse">✔</p>';
            break;
        case 'Lot / Farmland':
            $displayText .= '<p class="assetsFirstLot">✔</p>';
            break;
        case 'House & Lot':
            $displayText .= '<p class="assetsFirstHo">✔</p>';
            break;
        case 'Commercial Building':
            $displayText .= '<p class="assetsFirstComm">✔</p>';
            break;
        case 'Fishpond / resort':
            $displayText .= '<p class="assetsFirstFish">✔</p>';
            break;
    }
}
echo $displayText;
?>
                    <p class="assetsFirstOthers"><?php echo $assetsFirstOthers; ?></p>

                    <?php
$assetsSecondOptions = explode(',', $assetsSecond);

$displayText = "";

foreach ($assetsSecondOptions as $option) {
    $trimmedOption = trim($option);

    switch ($trimmedOption) {
        case 'Automobile':
            $displayText .= '<p class="assetsSecondAuto">✔</p>';
            break;
        case 'Personal Computer':
            $displayText .= '<p class="assetsSecondPers">✔</p>';
            break;
        case 'Boats':
            $displayText .= '<p class="assetsSecondBoats">✔</p>';
            break;
        case 'Heavy Equipment':
            $displayText .= '<p class="assetsSecondHeav">✔</p>';
            break;
        case 'Laptops':
            $displayText .= '<p class="assetsSecondLap">✔</p>';
            break;
        case 'Drones':
            $displayText .= '<p class="assetsSecondDro">✔</p>';
            break;
        case 'Motorcycle':
            $displayText .= '<p class="assetsSecondMot">✔</p>';
            break;
        case 'Mobile Phones':
            $displayText .= '<p class="assetsSecondMob">✔</p>';
            break;
    }
}
echo $displayText;
?>
                    <p class="assetsSecondOthers"><?php echo $assetsSecondOthers; ?></p>

                    <?php
  if ($row['monthlyIncome'] === '60,000 and above') {
    $displayText = '<p class="sixtyab">✔</p>';
  } elseif ($row['monthlyIncome'] === '50,000 to 60,000') {
    $displayText = '<p class="fiftyab">✔</p>';
  }elseif ($row['monthlyIncome'] === '40,000 to 50,000') {
    $displayText = '<p class="fourtyab">✔</p>';
  } elseif ($row['monthlyIncome'] === '30,000 to 40,000') {
    $displayText = '<p class="thirtyab">✔</p>';
  } elseif ($row['monthlyIncome'] === '20,000 to 30,000') {
    $displayText = '<p class="twentyab">✔</p>';
  } elseif ($row['monthlyIncome'] === '10,000 to 20,000') {
    $displayText = '<p class="tenab">✔</p>';
  } elseif ($row['monthlyIncome'] === '5,000 to 10,000') {
    $displayText = '<p class="fiveab">✔</p>';
  }elseif ($row['monthlyIncome'] === '1,000 to 5,000') {
    $displayText = '<p class="oneab">✔</p>';
  }elseif ($row['monthlyIncome'] === 'Below 1,000') {
    $displayText = '<p class="onebel">✔</p>';
  } else {
    $displayText = " ";
  }
  echo $displayText;
  ?>

                    <?php
$problemsOptions = explode(',', $problems);

$displayText = "";

foreach ($problemsOptions as $option) {
    $trimmedOption = trim($option);

    switch ($trimmedOption) {
        case 'Lack of income / resources':
            $displayText .= '<p class="problemsLack">✔</p>';
            break;
        case 'Loss of income / resources':
            $displayText .= '<p class="problemsLoss">✔</p>';
            break;
        case 'Skills / capability training':
            $displayText .= '<p class="problemsSkills">✔</p>';
            break;
        case 'Livelihood opportunities':
            $displayText .= '<p class="problemsLive">✔</p>';
            break;
    }
}
echo $displayText;
?>
                    <p class="problemsOthers"><?php echo $problemsOthers; ?></p>

                    <?php
  if ($row['bloodType'] === 'O') {
    $displayText = '<p class="bloodTypeO">✔</p>';
  } elseif ($row['bloodType'] === 'A') {
    $displayText = '<p class="bloodTypeA">✔</p>';
  }elseif ($row['bloodType'] === 'B') {
    $displayText = '<p class="bloodTypeB">✔</p>';
  } elseif ($row['bloodType'] === 'AB') {
    $displayText = '<p class="bloodTypeAB">✔</p>';
  } elseif ($row['bloodType'] === "Don't know") {
    $displayText = '<p class="bloodTypeDo">✔</p>';
  }  else {
    $displayText = " ";
  }
  echo $displayText;
  ?>

                    <p class="physicalDisability"><?php echo $physicalDisability; ?></p>

                    <?php
$medicalConcernOptions = explode(',', $medicalConcern);

$displayText = "";

foreach ($medicalConcernOptions as $option) {
    $trimmedOption = trim($option);

    switch ($trimmedOption) {
        case 'Health problems/ ailments':
            $displayText .= '<p class="medicalConcernHealth">✔</p>';
            break;
        case 'Hypertension':
            $displayText .= '<p class="medicalConcernHyper">✔</p>';
            break;
        case 'Arthritis / Gout':
            $displayText .= '<p class="medicalConcernArth">✔</p>';
            break;
        case 'Coronary Heart Disease':
            $displayText .= '<p class="medicalConcernCoro">✔</p>';
            break;
        case 'Diabetes':
            $displayText .= '<p class="medicalConcernDia">✔</p>';
            break;
        case 'Chronic Kidney Disease':
            $displayText .= '<p class="medicalConcernChro">✔</p>';
            break;
        case 'Alzheimer / Dementia':
            $displayText .= '<p class="medicalConcernAlzh">✔</p>';
            break;
        case 'Pulmonary Disease':
            $displayText .= '<p class="medicalConcernPul">✔</p>';
            break;
    }
}
echo $displayText;
?>
                    <p class="medicalConcernOthers"><?php echo $medicalConcernOthers; ?></p>


                    <?php
  if ($row['dentalConcern'] === 'Needs Dental Care') {
    $displayText = '<p class="dentalConcernNeeds">✔</p>';
  }  else {
    $displayText = " ";
  }
  echo $displayText;
  ?>

                    <p class="dentalConcernOthers"><?php echo $dentalConcernOthers; ?></p>

                    <?php
$opticalOptions = explode(',', $row['optical']);

$displayText = "";

foreach ($opticalOptions as $option) {
    $trimmedOption = trim($option);

    switch ($trimmedOption) {
        case 'Eye Impairment':
            $displayText .= '<p class="opticalEye">✔</p>';
            break;
        case 'Needs eye care':
            $displayText .= '<p class="opticalNeeds">✔</p>';
            break;
    }
}
echo $displayText;
?>



                    <p class="opticalOthers"><?php echo $opticalOthers; ?></p>

                    <?php
  if ($row['hearing'] === 'Aural impairment / Hearing impairment') {
    $displayText = '<p class="hearingAural">✔</p>';
  }  else {
    $displayText = " ";
  }
  echo $displayText;
  ?>

                    <p class="hearingOthers"><?php echo $hearingOthers; ?></p>



                    <?php
$socialEmotionalOptions = explode(',', $row['socialEmotional']);

$displayText = "";

foreach ($socialEmotionalOptions as $option) {
    $trimmedOption = trim($option);

    switch ($trimmedOption) {
        case 'Feeling neglect / rejection':
            $displayText .= '<p class="socialEmotionalFeel">✔</p>';
            break;
        case 'Feeling helplessness / worthlessness':
            $displayText .= '<p class="socialEmotionalFeelWor">✔</p>';
            break;
        case 'Feeling loneliness / isolate':
            $displayText .= '<p class="socialEmotionalFeelIso">✔</p>';
            break;
        case 'Lack leisure / recreational activities':
            $displayText .= '<p class="socialEmotionalLack">✔</p>';
            break;
        case 'Lack SC friendly environment':
            $displayText .= '<p class="socialEmotionalLackSC">✔</p>';
            break;

    }
}
echo $displayText;
?>


                    <p class="socialEmotionalOthers"><?php echo $socialEmotionalOthers; ?></p>


                    <?php
$areaDifficultyOptions = explode(',', $row['areaDifficulty']);

$displayText = "";

foreach ($areaDifficultyOptions as $option) {
    $trimmedOption = trim($option);

    switch ($trimmedOption) {
        case 'High Cost of medicines':
            $displayText .= '<p class="areaDifficultyHigh">✔</p>';
            break;
        case 'Lack of medicines':
            $displayText .= '<p class="areaDifficultyLack">✔</p>';
            break;
        case 'Lack of medical attention':
            $displayText .= '<p class="areaDifficultyLack1">✔</p>';
            break;

    }
}
echo $displayText;
?>

                    <p class="areaDifficultyOthers"><?php echo $areaDifficultyOthers; ?></p>


                    <p class="medicines1"><?php echo $medicine1; ?></p>
                    <p class="medicines2"><?php echo $medicine2; ?></p>
                    <p class="medicines3"><?php echo $medicine3; ?></p>
                    <p class="medicines4"><?php echo $medicine4; ?></p>
                    <p class="medicines5"><?php echo $medicine5; ?></p>
                    <p class="medicines6"><?php echo $medicine6; ?></p>
                    <p class="medicines7"><?php echo $medicine7; ?></p>
                    <p class="medicines8"><?php echo $medicine8; ?></p>
                    <p class="medicines9"><?php echo $medicine9; ?></p>
                    <p class="medicines10"><?php echo $medicine10; ?></p>
                    <p class="medicines11"><?php echo $medicine11; ?></p>
                    <p class="medicines12"><?php echo $medicine12; ?></p>

                    <?php
  if ($row['scheduledMedical'] === 'Yes') {
    $displayText = '<p class="scheduledMedicalYes">✔</p>';
  } elseif ($row['scheduledMedical'] === 'No') {
    $displayText = '<p class="scheduledMedicalNo">✔</p>';
  }
  echo $displayText;
  ?>

                    <?php
  if ($row['scheduledMedical1'] === 'Yearly') {
    $displayText = '<p class="scheduledMedical1Yearly">✔</p>';
  } elseif ($row['scheduledMedical1'] === 'Every 6 months') {
    $displayText = '<p class="scheduledMedical1Eve">✔</p>';
  }
  echo $displayText;
  ?>

                    <p class="scheduledMedical1Others"><?php echo $scheduledMedical1Others; ?></p>

                </div>
            </div>
        </div>
    </div>
    <button class="printbutton" id="printbutton">
        <img src="images/printicon.png" class="printicon">
        Print this page
    </button>

    <script>
    const printBtn = document.getElementById("printbutton");

    printBtn.addEventListener("click", function() {
        print();

    })

    const barangayElement = document.querySelector(".barangay");
    const wordsCount = barangayElement.textContent.trim().split(" ").length;
    if (wordsCount > 25) {
        barangayElement.classList.add("long");
    }
    </script>
</body>

</html>