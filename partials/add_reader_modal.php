<!-- Add Reader Modal -->
<div class="modal fade" id="addReaderModal" tabindex="-1" aria-labelledby="addReaderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addReaderModalLabel">Add New Reader</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addReaderForm" action="controllers/UserControllers.php" method="POST">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="date_of_birth" name="dob" required>
                    </div>
                    <button type="submit" name="add_reader" class="btn" style="background-color: #0b5ed7; color: white;">
    Add Reader
</button>

                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                let lat = position.coords.latitude;
                let lon = position.coords.longitude;

                // Fetch city name using OpenStreetMap API
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.address && data.address.city) {
                            document.getElementById("city").value = data.address.city;
                        } else if (data.address && data.address.town) {
                            document.getElementById("city").value = data.address.town;
                        } else if (data.address && data.address.village) {
                            document.getElementById("city").value = data.address.village;
                        }
                    })
                    .catch(error => console.log("Error fetching location:", error));
            }, function(error) {
                console.log("Geolocation error:", error.message);
            });
        } else {
            console.log("Geolocation is not supported by this browser.");
        }
    });
</script>
