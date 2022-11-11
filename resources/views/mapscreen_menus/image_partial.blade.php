<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Image (English):</label>
            <label class="custom-file">
                <input type="file" class="custom-file-input" name="image_en" accept="image/*">
                <span class="custom-file-label">Choose file</span>
            </label>
            <span class="form-text text-muted">Accepted formats: gif, png, jpg</span>
            <span class="form-text text-muted image_en_name">{{ isset($menu) ?? $menu->image_en }}</span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Image (Arabic):</label>
            <label class="custom-file">
                <input type="file" class="custom-file-input" name="image_ar" accept="image/*">
                <span class="custom-file-label">Choose file</span>
            </label>
            <span class="form-text text-muted">Accepted formats: gif, png, jpg</span>
            <span class="form-text text-muted image_ar_name">{{ isset($menu) ?? $menu->image_ar }}</span>
        </div>
    </div>
</div>
