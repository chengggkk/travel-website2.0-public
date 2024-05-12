<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="modal.css">

</head>

<body>
    <!-- Button trigger modal -->
    <button type="button" id="click-note" class="noteblock" data-bs-toggle="modal" data-bs-target="#note" style="height: 25px; font-size:15px;">
    <i class="fi fi-rr-memo-pad"></i>備忘錄
    </button>

    <!-- Modal -->
    <div class="modal fade" id="note" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">備忘錄</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">編輯</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

