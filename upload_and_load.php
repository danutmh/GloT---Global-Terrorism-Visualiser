<?php
require 'db_connect.php';

// Check if a file was uploaded
if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["file"]["name"]);
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file is a CSV file
    if ($fileType != "csv") {
        echo "Sorry, only CSV files are allowed.";
        exit;
    }

    // Move uploaded file to the target directory
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        // Process the CSV file and load data into MySQL tables
        $csvFile = $targetFile;

        // Open the CSV file
        if (($handle = fopen($csvFile, 'r')) !== FALSE) {
            // Get the first row as headers
            $headers = fgetcsv($handle, 50000, ',');

            // Loop through each row of the file
            $eventStmt = $conn->prepare("INSERT INTO events (
                eventid, iyear, imonth, iday, approxdate, extended, resolution, summary, crit1, crit2, crit3, doubtterr, 
                alternative, alternative_txt, multiple, related
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $locationStmt = $conn->prepare("INSERT INTO location (
                eventid, country, country_txt, region, region_txt, provstate, city, latitude, longitude, specificity, 
                vicinity, location
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $attackStmt = $conn->prepare("INSERT INTO attack (
                eventid, attacktype1, attacktype1_txt, attacktype2, attacktype2_txt, attacktype3, attacktype3_txt, 
                success, suicide
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $targetStmt = $conn->prepare("INSERT INTO target (
                eventid, targtype1, targtype1_txt, targsubtype1, targsubtype1_txt, corp1, target1, natlty1, natlty1_txt, 
                targtype2, targtype2_txt, targsubtype2, targsubtype2_txt, corp2, target2, natlty2, natlty2_txt, 
                targtype3, targtype3_txt, targsubtype3, targsubtype3_txt, corp3, target3, natlty3, natlty3_txt
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $perpetratorStmt = $conn->prepare("INSERT INTO perpetrator (
                eventid, gname, gsubname, gname2, gsubname2, gname3, gsubname3, motive, guncertain1, guncertain2, 
                guncertain3, individual, nperps, nperpcap
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $claimStmt = $conn->prepare("INSERT INTO claim (
                eventid, claimed, claimmode, claimmode_txt, claim2, claimmode2, claimmode2_txt, claim3, claimmode3, 
                claimmode3_txt, compclaim
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $weaponStmt = $conn->prepare("INSERT INTO weapon (
                eventid, weaptype1, weaptype1_txt, weapsubtype1, weapsubtype1_txt, weaptype2, weaptype2_txt, 
                weapsubtype2, weapsubtype2_txt, weaptype3, weaptype3_txt, weapsubtype3, weapsubtype3_txt, weaptype4, 
                weaptype4_txt, weapsubtype4, weapsubtype4_txt, weapdetail
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $casualtiesStmt = $conn->prepare("INSERT INTO casualties (
                eventid, nkill, nkillus, nkillter, nwound, nwoundus, nwoundte
            ) VALUES (?, ?, ?, ?, ?, ?, ?)");

            $propertyStmt = $conn->prepare("INSERT INTO property_damage (
                eventid, property, propextent, propextent_txt, propvalue, propcomment
            ) VALUES (?, ?, ?, ?, ?, ?)");

            $hostageStmt = $conn->prepare("INSERT INTO hostage_kidnapping (
                eventid, ishostkid, nhostkid, nhostkidus, nhours, ndays, divert, kidhijcountry, ransom, ransomamt, 
                ransomamtus, ransompaid, ransompaidus, ransomnote, hostkidoutcome, hostkidoutcome_txt, nreleased
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            while (($row = fgetcsv($handle, 5000, ",")) !== FALSE) {
                // Insert into events table
                $eventStmt->bind_param("iiissisiiiibiisi", $row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[18], $row[19], $row[20], $row[21], $row[22], $row[23], $row[24], $row[25], $row[127]);
                $eventStmt->execute();

                // Insert into location table
                $locationStmt->bind_param("iisisssddiis", $row[0], $row[7], $row[8], $row[9], $row[10], $row[11], $row[12], $row[13], $row[14], $row[15], $row[16], $row[17]);
                $locationStmt->execute();

                // Insert into attack table
                $attackStmt->bind_param("iisiisiib", $row[0], $row[27], $row[28], $row[29], $row[30], $row[31], $row[32], $row[26], $row[35]);
                $attackStmt->execute();

                // Insert into target table
                $targetStmt->bind_param("iisisssisisisssisisisssis", $row[0], $row[34], $row[35], $row[36], $row[37], $row[38], $row[39], $row[40], $row[41], $row[42], $row[43], $row[44], $row[45], $row[46], $row[47], $row[48], $row[49], $row[50], $row[51], $row[52], $row[53], $row[54], $row[55], $row[56], $row[57]);
                $targetStmt->execute();

                // Insert into perpetrator table
                $perpetratorStmt->bind_param("isssssssiiiiii", $row[0], $row[57], $row[58], $row[59], $row[60], $row[61], $row[62], $row[63], $row[64], $row[65], $row[66], $row[67], $row[68], $row[69]);
                $perpetratorStmt->execute();

                // Insert into claim table
                $claimStmt->bind_param("iiisiisiisi", $row[0], $row[70], $row[71], $row[72], $row[73], $row[74], $row[75], $row[76], $row[77], $row[78], $row[79]);
                $claimStmt->execute();

                // Insert into weapon table
                $weaponStmt->bind_param("iisisisisisisisiss", $row[0], $row[80], $row[81], $row[82], $row[83], $row[84], $row[85], $row[86], $row[87], $row[88], $row[89], $row[90], $row[91], $row[92], $row[93], $row[94], $row[95], $row[96]);
                $weaponStmt->execute();

                // Insert into casualties table
                $casualtiesStmt->bind_param("iiiiiii", $row[0], $row[97], $row[98], $row[99], $row[100], $row[101], $row[102]);
                $casualtiesStmt->execute();

                // Insert into property table
                $propertyStmt->bind_param("iiisds", $row[0], $row[103], $row[104], $row[105], $row[106], $row[107]);
                $propertyStmt->execute();

                // Insert into hostage table
                $hostageStmt->bind_param("iiiiiissiddddsisi", $row[0], $row[108], $row[109], $row[110], $row[111], $row[112], $row[113], $row[114], $row[115], $row[116], $row[117], $row[118], $row[119], $row[120], $row[121], $row[122], $row[123]);
                $hostageStmt->execute();
            }

            fclose($handle);
        }
        echo "Data loaded successfully.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
} else {
    echo "Error uploading file: " . $_FILES["file"]["error"];
}

// Close the database connection
$conn->close();
?>
