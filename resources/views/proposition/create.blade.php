<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <title>Crear Propuesta</title>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <form id="form" action="{{ route('propositions.store') }}" method="POST"
                    class="p-5 bg-light rounded">
                    @csrf
                    <h2 class="mb-3">Make offer</h2>
                    <div class="form-group">
                        <label for="price" class="font-weight-bold">Price</label>
                        <input type="text" class="form-control" id="price" name="price" required>
                        <script>
                            document.getElementById('price').addEventListener('input', function(e) {
                                var input = e.target.value;
                                // Allow only 1 dot "."
                                var numberOfDots = input.split('.').length - 1;
                                // Allow only 2 digits after the dot
                                var numberOfDecimalPlaces = input.indexOf('.') !== -1 ? input.split('.')[1].length : 0;
                                // Allow only 8 digits before the dot
                                var numberOfWholeNumbers = input.indexOf('.') !== -1 ? input.split('.')[0].length : input.length;
                                if (numberOfDots > 1 || numberOfDecimalPlaces > 2 || numberOfWholeNumbers > 8) {
                                    e.target.value = input.substring(0, input.length - 1);
                                }
                            });
                        </script>
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="workshop_id" name="workshop_id" value="{{ $workshop->id }}">
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="service_request_id" name="service_request_id"
                            value="{{ $service_request->id }}">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Send offer</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('form').addEventListener('submit', function() {
            setTimeout(function() {
                window.close();
            }, 500);
        });
    </script>
</body>

</html>
