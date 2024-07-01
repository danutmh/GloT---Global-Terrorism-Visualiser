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
            while (($row = fgetcsv($handle, 50000, ',')) !== FALSE) {
                // Map the row data to the respective columns
				$eventid = $row[0];
				$iyear = $row[1];
				$imonth = $row[2];
				$iday = $row[3];
				$approxdate = $row[4];
				$extended = $row[5];
				$resolution = $row[6];
				$country = $row[7];
				$country_txt = $row[8];
				$region = $row[9];
				$region_txt = $row[10];
				$provstate = $row[11];
				$city = $row[12];
				$latitude = $row[13];
				$longitude = $row[14];
				$specificity = $row[15];
				$vicinity = $row[16];
				$location = $row[17];
				$summary = $row[18];
				$crit1 = $row[19];
				$crit2 = $row[20];
				$crit3 = $row[21];
				$doubtterr = $row[22];
				$alternative = $row[23];
				$alternative_txt = $row[24];
				$multiple = $row[25];
				$success = $row[26];
				$suicide = $row[27];
				$attacktype1 = $row[28];
				$attacktype1_txt = $row[29];
				$attacktype2 = $row[30];
				$attacktype2_txt = $row[31];
				$attacktype3 = $row[32];
				$attacktype3_txt = $row[33];
				$targtype1 = $row[34];
				$targtype1_txt = $row[35];
				$targsubtype1 = $row[36];
				$targsubtype1_txt = $row[37];
				$corp1 = $row[38];
				$target1 = $row[39];
				$natlty1 = $row[40];
				$natlty1_txt = $row[41];
				$targtype2 = $row[42];
				$targtype2_txt = $row[43];
				$targsubtype2 = $row[44];
				$targsubtype2_txt = $row[45];
				$corp2 = $row[46];
				$target2 = $row[47];
				$natlty2 = $row[48];
				$natlty2_txt = $row[49];
				$targtype3 = $row[50];
				$targtype3_txt = $row[51];
				$targsubtype3 = $row[52];
				$targsubtype3_txt = $row[53];
				$corp3 = $row[54];
				$target3 = $row[55];
				$natlty3 = $row[56];
				$natlty3_txt = $row[57];
				$gname = $row[58];
				$gsubname = $row[59];
				$gname2 = $row[60];
				$gsubname2 = $row[61];
				$gname3 = $row[62];
				$gsubname3 = $row[63];
				$motive = $row[64];
				$guncertain1 = $row[65];
				$guncertain2 = $row[66];
				$guncertain3 = $row[67];
				$individual = $row[68];
				$nperps = $row[69];
				$nperpcap = $row[70];
				$claimed = $row[71];
				$claimmode = $row[72];
				$claimmode_txt = $row[73];
				$claim2 = $row[74];
				$claimmode2 = $row[75];
				$claimmode2_txt = $row[76];
				$claim3 = $row[77];
				$claimmode3 = $row[78];
				$claimmode3_txt = $row[79];
				$compclaim = $row[80];
				$weaptype1 = $row[81];
				$weaptype1_txt = $row[82];
				$weapsubtype1 = $row[83];
				$weapsubtype1_txt = $row[84];
				$weaptype2 = $row[85];
				$weaptype2_txt = $row[86];
				$weapsubtype2 = $row[87];
				$weapsubtype2_txt = $row[88];
				$weaptype3 = $row[89];
				$weaptype3_txt = $row[90];
				$weapsubtype3 = $row[91];
				$weapsubtype3_txt = $row[92];
				$weaptype4 = $row[93];
				$weaptype4_txt = $row[94];
				$weapsubtype4 = $row[95];
				$weapsubtype4_txt = $row[96];
				$weapdetail = $row[97];
				$nkill = $row[98];
				$nkillus = $row[99];
				$nkillter = $row[100];
				$nwound = $row[101];
				$nwoundus = $row[102];
				$nwoundte = $row[103];
				$property = $row[104];
				$propextent = $row[105];
				$propextent_txt = $row[106];
				$propvalue = $row[107];
				$propcomment = $row[108];
				$ishostkid = $row[109];
				$nhostkid = $row[110];
				$nhostkidus = $row[111];
				$nhours = $row[112];
				$ndays = $row[113];
				$divert = $row[114];
				$kidhijcountry = $row[115];
				$ransom = $row[116];
				$ransomamt = $row[117];
				$ransomamtus = $row[118];
				$ransompaid = $row[119];
				$ransompaidus = $row[120];
				$ransomnote = $row[121];
				$hostkidoutcome = $row[122];
				$hostkidoutcome_txt = $row[123];
				$nreleased = $row[124];
				$addnotes = $row[125];
				$scite1 = $row[126];
				$scite2 = $row[127];
				$scite3 = $row[128];
				$dbsource = $row[129];
				$INT_LOG = $row[130];
				$INT_IDEO = $row[131];
				$INT_MISC = $row[132];
				$INT_ANY = $row[133];
				$related = $row[134];

                // Insert data into the events table
                $sql_events = "INSERT INTO events (eventid, iyear, imonth, iday, approxdate, extended, resolution, summary, crit1, crit2, crit3, doubtterr, alternative, alternative_txt, multiple, related) VALUES ('$eventid', '$iyear', '$imonth', '$iday', '$approxdate', '$extended', '$resolution', '$summary', '$crit1', '$crit2', '$crit3', '$doubtterr', '$alternative', '$alternative_txt', '$multiple', '$related')";
                $conn->query($sql_events);
			
				$sql_location = "INSERT INTO location (eventid, country, country_txt, region, region_txt, provstate, city, latitude, longitude, specificity, vicinity, location)
					 VALUES ('$eventid', '$country', '$country_txt', '$region', '$region_txt', '$provstate', '$city', '$latitude', '$longitude', '$specificity', '$vicinity', '$location')";
				$conn->query($sql_location);

				// Insert data into the attack table
				$sql_attack = "INSERT INTO attack (eventid, attacktype1, attacktype1_txt, attacktype2, attacktype2_txt, attacktype3, attacktype3_txt, success, suicide)
							   VALUES ('$eventid', '$attacktype1', '$attacktype1_txt', '$attacktype2', '$attacktype2_txt', '$attacktype3', '$attacktype3_txt', '$success', '$suicide')";
				$conn->query($sql_attack);
				
				$sql_casualties = "INSERT INTO casualties (eventid, nkill, nkillus, nkillter, nwound, nwoundus, nwoundte)
								   Values ('$eventid', '$nkill', '$nkillus', '$nkillter', '$nwound' , '$nwoundus', '$nwoundte')";
				$conn->query($sql_casualties);
				
				
				$sql_hostage_kidnapping = "INSERT INTO attack (eventid, ishostkid, nhostkid, nhostkidus, nhours, ndays, divert, kidhijcountry, ransom, ransomamt, ransomamtus, ransompaid, ransompaidus, ransomnote, hostkidoutcome, hostkidoutcome_txt, nreleased)
							   VALUES ('$eventid', '$ishostkid', '$nhostkid', '$nhostkidus', '$nhours', '$ndays', '$divert', '$kidhijcountry', '$ransom', '$ransomamt', '$ransomamtus, '$ransompaid', '$ransompaidus', '$ransomnote', '$hostkidoutcome', '$hostkidoutcome_txt', '$nreleased')";
				$conn->query($sql_hostage_kidnapping);
				
				$sql_perpetrator = "INSERT INTO attack (eventid, gname, gsubname, gname2, gsubname2, gname3, gsubname3, motive, guncertain1, guncertain2, guncertain3, individual, nperps, nperpcap)
							   VALUES ('$eventid', '$gname', '$gsubname', '$gname2', '$gsubname2', '$gname3', '$gsubname3', '$motive', '$guncertain1', '$guncertain2', '$guncertain3', '$individual', '$nperps', '$nperpcap')";
				$conn->query($sql_perpetrator);
				
				$sql_property_damage = "INSERT INTO attack (eventid, property, propextent,propextent_txt ,propvalue ,propcomment)
							   VALUES ('$eventid', '$property', '$propextent','$propextent_txt','$propvalue','$propcomment')";
				$conn->query($sql_property_damage);
				
				$sql_target = "INSERT INTO attack (eventid, targtype1, targtype1_txt, targsubtype1, targsubtype1_txt, corp1, target1, natlty1, natlty1_txt, targtype2, targtype2_txt, targsubtype2, targsubtype2_txt, corp2, target2, natlty2, natlty2_txt, targtype3, targtype3_txt, targsubtype3, targsubtype3_txt, corp3, target3, natlty3, natlty3_txt)
							   VALUES ('$eventid', '$targtype1', '$targtype1_txt', '$targsubtype1', '$targsubtype1_txt', '$corp1', '$target1', '$natlty1', '$natlty1_txt', '$targtype2', '$targtype2_txt', '$targsubtype2', '$targsubtype2_txt', '$corp2', '$target2', '$natlty2', '$natlty2_txt', '$targtype3', '$targtype3_txt', '$targsubtype3', '$targsubtype3_txt', '$corp3', '$target3', '$natlty3', '$natlty3_txt')";
				$conn->query($sql_target);
				
				$sql_weapon = "INSERT INTO attack (eventid, weaptype1, weaptype1_txt, weapsubtype1, weapsubtype1_txt, weaptype2, weaptype2_txt, weapsubtype2, weapsubtype2_txt, weaptype3, weaptype3_txt, weapsubtype3, weapsubtype3_txt, weaptype4, weaptype4_txt, weapsubtype4, weapsubtype4_txt, weapdetail)
							   VALUES ('$eventid', '$weaptype1', '$weaptype1_txt', '$weapsubtype1', '$weapsubtype1_txt', '$weaptype2', '$weaptype2_txt', '$weapsubtype2', '$weapsubtype2_txt', '$weaptype3', '$weaptype3_txt', '$weapsubtype3', '$weapsubtype3_txt', '$weaptype4', '$weaptype4_txt', '$weapsubtype4', '$weapsubtype4_txt', '$weapdetail')";
				$conn->query($sql_weapon);
				
				$sql_claim = "INSERT INTO attack (eventid, claimed, claimmode, claimmode_txt, claim2, claimmode2, claimmode2_txt, claim3, claimmode3, claimmode3_txt, compclaim)
							   VALUES ('$eventid', '$claimed', '$claimmode', '$claimmode_txt', '$claim2', '$claimmode2', '$claimmode2_txt', '$claim3', '$claimmode3', '$claimmode3_txt', '$compclaim')";
				$conn->query($sql_claim);
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
