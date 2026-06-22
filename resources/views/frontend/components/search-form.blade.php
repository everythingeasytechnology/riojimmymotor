<form action="{{ url('/parts') }}" method="GET" class="row g-3">
    <!-- Year Select -->
    <div class="col-md-6 col-12">
        <label for="search-year" class="form-label fw-600 text-dark small">1. SELECT YEAR</label>
        <select class="form-select border-secondary-subtle" name="year" id="search-year" required style="padding: 12px;">
            <option value="">Select Year</option>
            <option value="2024">2024</option>
            <option value="2023">2023</option>
            <option value="2022">2022</option>
            <option value="2021">2021</option>
        </select>
    </div>

    <!-- Make Select -->
    <div class="col-md-6 col-12">
        <label for="search-make" class="form-label fw-600 text-dark small">2. SELECT MAKE</label>
        <select class="form-select border-secondary-subtle" name="make" id="search-make" disabled required style="padding: 12px;">
            <option value="">Select Make</option>
        </select>
    </div>

    <!-- Model Select -->
    <div class="col-md-6 col-12">
        <label for="search-model" class="form-label fw-600 text-dark small">3. SELECT MODEL</label>
        <select class="form-select border-secondary-subtle" name="model" id="search-model" disabled required style="padding: 12px;">
            <option value="">Select Model</option>
        </select>
    </div>

    <!-- Part Name Select or Input -->
    <div class="col-md-6 col-12">
        <label for="search-part" class="form-label fw-600 text-dark small">4. ENTER PART NAME</label>
        <input type="text" class="form-control border-secondary-subtle font-poppins" name="part_name" id="search-part" placeholder="e.g. Engine, Transmission, Bumper" required style="padding: 12px;">
    </div>

    <!-- Submit Search Button -->
    <div class="col-12 mt-4">
        <button type="submit" class="btn btn-primary w-100 py-3 text-uppercase font-poppins text-white shadow-sm">
            <i class="fa fa-search me-2"></i> Find My Part Now
        </button>
    </div>

    <div class="col-12 text-center mt-3">
        <span class="text-muted small"><i class="fa fa-shield-alt text-success me-1"></i> Your search is 100% private and secure.</span>
    </div>
</form>
