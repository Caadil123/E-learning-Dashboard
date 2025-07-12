<!-- Modal -->
<div class="modal fade" id="add-section" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="section-form" action="" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="addSectionModalLabel">Add New Section</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="form-title Section-info">Section Information <span>
                              
                    </button>
                        </div>
                        <input type="hidden" name="sectionid" id="sectionid" value="0">
                        <input type="hidden" id="operation" name="operation" value="insert">
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>section Name <span class="login-danger">*</span></label>
                                <input class="form-control p-4" type="text" placeholder="Enter section Name" name="sectionName" id="sectionName">
                                <div class="error-message" id="sectionName-error"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                            <label>Course Name <span class="login-danger">*</span></label>
                                <select class="form-control select" name="Course" id="Course">
                                    <option value="" disabled selected>Please Select Course</option>
                                    <?php foreach (read('courses') as $courses) { 
                                        if($courses['Instructor_Id'] == $_SESSION['userId']){
                                        ?>
                                        <option value="<?= $courses['ID'] ?>">
                                            <?= readcolumn('courses', 'Course_name', $courses['ID']) ?>
                                        </option>
                                    <?php } } ?>
                                </select>
                                <div class="error-message" id="courses-error"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="btn_add_section" class="btn btn-primary" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Delete modal -->
<div class="modal fade" id="delete-section" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="Section-form" action="" method="post">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">Delete Section</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="text" name="sectionid" id="section_id">
                        <p class="lead">Are you sure to delete this Section?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="btn_delete_section" class="btn btn-primary" value="Yes">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
      function handleForm(id) {
        $("#sectionid").val(id);
        console.log(id);
        $("#addSectionModalLabel").html("Update Section");
        $("[name='btn_add_section']").val("Update");

        // Fetch student data
        $.ajax({
            method: "POST",
            url: "includes/ajaxReader.php",
            data: {
                table: "sections",
                id: id
            }
        })
            .done((res) => {
                // console.log(res);
                var res = JSON.parse(res);
                // console.log(res);
                $("#sectionName").val(res.Section_name );
                $("#Course").val(res.Course_ID);
                $('#operation').val('update');
                // console.log(document.getElementById('operation').value);
                
                $('#sectionid').val(res.ID);

            })
    }
       function clearForm() {
        $('#addSectionModalLabel').html('Add New Section');
        $("[name='btn_add_section']").val('Save');
        $("#sectionName").val('')
        $("#Course").val('')
        $('#operation').val('insert');
        $('#sectionid').val(0);
    }

    function setIdToDelete(id) {
        $('#section_id').val(id);
    }

    document.getElementById('section-form').addEventListener('submit', function (event) {
        // event.preventDefault();
        // Clear previous error messages
        document.querySelectorAll('.error-message').forEach(function (el) {
            el.textContent = '';
        });

        let isValid = true;

        // Validate Full Name
        const sectionName = document.getElementById('sectionName').value;
        // console.log(instructor_Name);
        if (sectionName.trim() === '') {
            isValid = false;
            document.getElementById('sectionName-error').textContent = 'section Name is required';
        }
        const Course = document.getElementById('Course').value;
        // console.log(Cat_desc);
        if (Course.trim() === '') {
            isValid = false;
            document.getElementById('courses-error').textContent = 'Course is required';
        }

        if (!isValid) {
            event.preventDefault();
        }
    });
</script>

<style>
    .error-message {
        color: red;
        font-size: 0.875em;
        margin-top: 5px;
    }
</style>