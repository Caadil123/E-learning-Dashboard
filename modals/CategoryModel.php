

<!-- Modal -->
<div class="modal fade" id="add-category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="category-form" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addCategoryModalLabel">Add New Category</h1>
                   <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="form-title student-info">Category Information <span><a href="javascript:;"><i class="feather-more-vertical"></i></a></span></h5>
                        </div>
                        <input type="hidden" name="categoryid" id="categoryid" value="0">
                        <input type="hidden" id="operation" name="operation" value="insert">
                        <div class="col-12 col-sm-5">
                            <div class="form-group local-forms">
                                <label>Category Name <span class="login-danger">*</span></label>
                                <input class="form-control p-3" type="text" placeholder="Enter Category Name" name="Cat_Name" id="Cat_Name">
                                <div class="error-message" id="Cat_Name-error"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-7">
                            <div class="form-group local-forms">
                                <label>Describtion <span class="login-danger">*</span></label>
                                <textarea class="form-control" name="Cat_desc" id="Cat_desc"
                                rows="3"></textarea>
                                <div class="error-message" id="Cat_desc-error"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="form-group local-forms">
                            <label for="exampleInputCatImage" class="form-label">Category Image</label>
                                    <input type="file" class="form-control p-3" name="category_image"
                                        id="exampleInputCatImage"
                                        accept="image/jpeg, image/png, image/jpg, image/webp">;
                                <div class="error-message" id="category_image-error"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <img id="catImageDisplay" src="" style="width: 150px; height: 150px; border-radius:50%" alt="Cat Image">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="btn_add_category" class="btn btn-primary" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Delete modal -->
<div class="modal fade" id="delete-category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form id="category-form" method="post">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="exampleModalLabel">Delete Category</h4>
                   <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="categoryid" id="category_id">
                        <p class="lead">Are you sure to delete this category?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="btn_delete_category" class="btn btn-primary" value="Yes">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
  function handleForm(id) {
    $("#categoryid").val(id);
    console.log(id);
    $("#addCategoryModalLabel").html("Update Category");
    $("[name='btn_add_category']").val("Update");

    // Fetch category data
    $.ajax({
        method: "POST",
        url: "includes/ajaxReader.php",
        data: {
            table: "categories",
            id: id
        }
    })
    .done((res) => {
        console.log(res);
        var res = JSON.parse(res);
        console.log(res);
        $("#Cat_Name").val(res.Cat_name);
        $("#Cat_desc").val(res.Cat_desc);
        $('#catImageDisplay').attr('src', res.Cat_image);
        $('#operation').val('update');
        console.log(document.getElementById('operation').value);
        $('#categoryid').val(res.ID);
    });
    }
       function clearForm() {
        $('#addCategoryModalLabel').html('Add New Category');
        $("[name='btn_add_category']").val('Save');
        $('#Cat_Name').val('')
        $('#Cat_desc').val('')
        $('#exampleInputCatImage').val('')
        $('#operation').val('insert');
        $('#categoryid').val(0);
    }

    function setIdToDelete(id) {
        $('#category_id').val(id);
    }

    document.getElementById('category-form').addEventListener('submit', function (event) {
        // event.preventDefault();
        // Clear previous error messages
        document.querySelectorAll('.error-message').forEach(function (el) {
            el.textContent = '';
        });

        let isValid = true;

        // Validate category Name
        const Cat_Name = document.getElementById('Cat_Name').value;
        console.log(Cat_Name);
        if (Cat_Name.trim() === '') {
            isValid = false;
            document.getElementById('Cat_Name-error').textContent = 'Category Name is required';
        }
         // Validate category describtionn
        const Cat_desc = document.getElementById('Cat_desc').value;
        console.log(Cat_desc);
        if (Cat_desc.trim() === '') {
            isValid = false;
            document.getElementById('Cat_desc-error').textContent = 'Cat_desc is required';
        }

        // Validate category image
        const Cat_image = document.getElementById('exampleInputCatImage').value;
        console.log(Cat_image);
        if (Cat_image.trim() === '') {
            isValid = false;
            document.getElementById('category_image-error').textContent = 'Cat_image number is required';
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