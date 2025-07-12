<!-- Modal -->
<div class="modal fade" id="add-content" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="content-form" action="" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="addcontentModalLabel">Add New Content</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="form-title Instructor-info">Content Information <span>


                        </div>
                        <input type="hidden" name="contentid" id="contentid" value="0">
                        <input type="hidden" id="operation" name="operation" value="insert">
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>content Name <span class="login-danger">*</span></label>
                                <input class="form-control p-4" type="text" placeholder="Enter content Name"
                                    name="contentName" id="contentName">
                                <div class="error-message" id="contentName-error"></div>
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
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Section Name <span class="login-danger">*</span></label>
                                <select class="form-control select" name="Section" id="section_id">
                                    <option value="" disabled selected>Please Select Section</option>
                                    <?php foreach (read('courses') as $courses) { 
                                        if($courses['Instructor_Id'] == $_SESSION['userId']){
                                        ?>
                                    <?php foreach (read('sections') as $section) { 
                                        if($section['Course_ID'] == $courses['ID']){
                                        ?>
                                        <option value="<?= $section['ID'] ?>">
                                            <?= readcolumn('sections', 'Section_name', $section['ID']) ?>
                                        </option>
                                    <?php } } ?>
                                    <?php } }?>
                                </select>
                                <div class="error-message" id="Section-error"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Content time <span class="login-danger">*</span></label>
                                <select class="form-control select" name="Content_time" id="Content_time">
                                    <option value="" disabled selected>Please Select course Content time</option>
                                    <option value="1 minutes">1 minutes</option>
                                    <option value="1:30 minutes">1:30 minutes</option>
                                    <option value="2 minutes">2 minutes</option>
                                    <option value="2:20 minutes">2:20 minutes</option>
                                    <option value="2:37 minutes">2:37 minutes</option>
                                    <option value="3 minutes">3 minutes</option>
                                    <option value="3:20 minutes">3:20 minutes</option>
                                    <option value="3:30 minutes">3:30 minutes</option>
                                    <option value="4 minutes">4 minutes</option>
                                    <option value="1 hour">1 hour</option>
                                </select>
                                <div class="error-message" id="Content_time-error"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label>Lesson <span class="login-danger">*</span></label>
                                <select class="form-control select" name="Lesson" id="Lesson">
                                    <option value="" disabled selected>Please Select course Lesson</option>
                                    <option value="Lesson 1">Lesson 1</option>
                                    <option value="Lesson 2">Lesson 2</option>
                                    <option value="Lesson 3">Lesson 3</option>
                                    <option value="Lesson 4">Lesson 4</option>
                                </select>
                                <div class="error-message" id="Lesson-error"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                                <label for="exampleInputContentVideo" class="form-label">Content Video</label>
                                <input type="file" class="form-control p-4" name="Content_Video"
                                    id="exampleInputContentVideo" accept="video/mp4, video/webm, video/ogg">
                                <div class="error-message" id="Content_Video-error"></div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-12 d-flex justify-content-center align-items-center">
                            <video controls style="width: 350px; height: 150px; border:2px solid black;" id="videoPlayer">
                                <source src="" style="display:hidden" type="video/mp4" id="contentvideoDisplay">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="btn_add_content" class="btn btn-primary" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Delete modal -->
<div class="modal fade" id="delete-content" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="category-form" action="" method="post">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">Delete content</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="contentid" id="content_id">
                        <p class="lead">Are you sure to delete this content?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="btn_delete_content" class="btn btn-primary" value="Yes">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function handleForm(id) {
        $("#contentid").val(id);
        console.log(id);
        $("#addcontentModalLabel").html("Update content");
        $("[name='btn_add_content']").val("Update");

        // Fetch student data
        $.ajax({
            method: "POST",
            url: "includes/ajaxReader.php",
            data: {
                table: "contents",
                id: id
            }
        })
            .done((res) => {
                // console.log(res);
                var res = JSON.parse(res);
                console.log(res);
                $("#contentName").val(res.Content_name);
                $("#Course").val(res.Course_ID);
                $("#section_id").val(res.Section_ID);
                $("#Content_time").val(res.Content_time);
                $("#Lesson").val(res.lesson);
                $("#contentvideoDisplay").attr('src', res.Content_Video); // Set the source
                $("#videoPlayer")[0].load(); // Reload the video element
                $('#operation').val('update');
                // console.log(document.getElementById('operation').value);

                $('#contentid').val(res.ID);
            })
    }
    function clearForm() {
        $('#addcontentModalLabel').html('Add New Content');
        $("[name='btn_add_content']").val('Save');
        $("#contentName").val('')
        $("#Course").val('')
        $("#section_id").val('')
        $("#Content_time").val('')
        $("#lesson").val('')
        // $("#videoPlayer").removeAttr("controls");
        $('#operation').val('insert');
        $('#contentid').val(0);
    }
    function setIdToDelete(id) {
        $('#content_id').val(id);
    }

    document.getElementById('content-form').addEventListener('submit', function (event) {
        // event.preventDefault();
        // Clear previous error messages
        document.querySelectorAll('.error-message').forEach(function (el) {
            el.textContent = '';
        });

        let isValid = true;

        // Validate Full Name
        const contentName = document.getElementById('contentName').value;
        console.log(contentName);
        if (contentName.trim() === '') {
            isValid = false;
            document.getElementById('contentName-error').textContent = 'content Name is required';
        }
        const Course = document.getElementById('Course').value;
        // console.log(Cat_desc);
        if (Course.trim() === '') {
            isValid = false;
            document.getElementById('courses-error').textContent = 'Course is required';
        }
        const Section = document.getElementById('section_id').value;
        // console.log(Cat_desc);
        if (Section.trim() === '') {
            isValid = false;
            document.getElementById('Section-error').textContent = 'Section is required';
        }

        const Content_time = document.getElementById('Content_time').value;
        // console.log(Cat_desc);
        if (Content_time.trim() === '') {
            isValid = false;
            document.getElementById('Content_time-error').textContent = 'Content time is required';
        }

        const Lesson = document.getElementById('Lesson').value;
        // console.log(Cat_desc);
        if (Lesson.trim() === '') {
            isValid = false;
            document.getElementById('Lesson-error').textContent = 'Lesson is required';
        }
        const ContentVideo = document.getElementById('exampleInputContentVideo').value;
        // console.log(Cat_desc);
        if (ContentVideo.trim() === '') {
            isValid = false;
            document.getElementById('Content_Video-error').textContent = 'Content Video is required';
        }

        if (!isValid) {
            event.preventDefault();
        }
    });
    document.addEventListener('DOMContentLoaded', function () {
        var courseSelect = document.getElementById('Course');
        console.log(courseSelect);

        var sectionSelect = document.getElementById('section_id');
        var initialCourseId = "<?php echo $content['Course_ID'] ?? ''; ?>";
        var initialSectionId = "<?php echo $content['Section_ID'] ?? ''; ?>";

        function loadSections(courseId, selectedSectionId) {
            if (courseId) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'get_sections.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            sectionSelect.innerHTML = xhr.responseText;
                            if (selectedSectionId) {
                                sectionSelect.value = selectedSectionId;
                            }
                        } else {
                            console.error('Failed to load sections. Status:', xhr.status);
                        }
                    }
                };
                xhr.send('Course=' + encodeURIComponent(courseId));
            } else {
                sectionSelect.innerHTML = '<option value="">Select Section</option>';
            }
        }
        // console.log(sectionSelect.innerHTML);


        // Load sections for the initial course if it's set
        if (initialCourseId) {
            loadSections(initialCourseId, initialSectionId);
        }

        // Add event listener for course selection change
        courseSelect.addEventListener('change', function () {
            loadSections(this.value);
        });
    });


</script>

<style>
    .error-message {
        color: red;
        font-size: 0.875em;
        margin-top: 5px;
    }
</style>