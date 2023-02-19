<form action="<?php echo  site_url(ADMIN_DIR . "reception/update_patient_data"); ?>" method="post">
    <table style="width: 100%;" class="table">

        <tbody>
            <tr>
                <td>Patient Name: </td>

                <td>

                    <input type="hidden" name="patient_id" value="<?php echo $patient->patient_id; ?>">

                    <span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
                    <input type="text" name="patient_name" value="<?php echo $patient->patient_name; ?>" autocomplete="off" class="form-control" style="" required="required" title="Name" placeholder="Name">


                </td>
            </tr>

            <tr>
                <td>Address: </td>
                <td><input type="text" name="patient_address" value="<?php echo $patient->patient_address; ?>" class="form-control" style="" required="required" title="Address" placeholder="Address"></td>
            </tr>
            <tr>
                <td>Age: </td>
                <td><input type="text" name="patient_age" value="<?php echo $patient->patient_age; ?>" class="form-control" style="" required="required" title="Patient Age" placeholder="Patient Age"></td>
            </tr>
            <tr>
                <td>Sex: </td>
                <td><input <?php if ($patient->patient_gender == 'Male') {  ?>checked <?php } ?> type="radio" name="patient_gender" value="Male" style="" required="required" class="uniform">
                    <label for="patient_gender" style="margin-left:10px;">Male</label>
                    <input <?php if ($patient->patient_gender == 'Female') { ?>checked <?php } ?> type="radio" name="patient_gender" value="Female" style="" required="required" class="uniform">
                    <label for="patient_gender" style="margin-left:10px;">Female</label>
                </td>
            </tr>


            <tr>
                <td>Mobile No:</td>
                <td><input type="text" minlength="11" name="patient_mobile_no" value="<?php echo $patient->patient_mobile_no; ?>" class="form-control" style="" title="Mobile No" placeholder="Mobile No"></td>


            </tr>
            <tr>
                <td>History File No:</td>
                <td><input type="text" name="history_file_no" value="<?php echo $patient->history_file_no; ?>" class="form-control" style="" title="History File No" placeholder="History File No"></td>


            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <br />
                    <input class="btn btn-success" type="submit" name="Update" value="Update" />
                </td>
            </tr>

        </tbody>
    </table>
</form>