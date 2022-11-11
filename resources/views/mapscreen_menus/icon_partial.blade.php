<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Icon (English):</label>
            <label class="custom-file">
                <input type="file" class="custom-file-input" name="icon_en" accept="image/*">
                <span class="custom-file-label">Choose file</span>
            </label>
            <span class="form-text text-muted">Accepted formats: gif, png, jpg</span>
            <span class="form-text text-muted icon_en_name">{{ isset($menu) ?? $menu->icon_en }}</span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Icon (Arabic):</label>
            <label class="custom-file">
                <input type="file" class="custom-file-input" name="icon_ar" accept="image/*">
                <span class="custom-file-label">Choose file</span>
            </label>
            <span class="form-text text-muted">Accepted formats: gif, png, jpg</span>
            <span class="form-text text-muted icon_ar_name">{{ isset($menu) ?? $menu->icon_ar }}</span>
        </div>
    </div>
</div>
