<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Nom <span class="text-danger">*</span></label>
        <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
               value="{{ old('nom', $eleve->nom ?? '') }}" required>
        @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Prénom <span class="text-danger">*</span></label>
        <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror"
               value="{{ old('prenom', $eleve->prenom ?? '') }}" required>
        @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Date de naissance <span class="text-danger">*</span></label>
        <input type="date" name="date_naissance"
               class="form-control @error('date_naissance') is-invalid @enderror"
               value="{{ old('date_naissance', isset($eleve) ? $eleve->date_naissance->format('Y-m-d') : '') }}"
               required>
        @error('date_naissance')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Sexe <span class="text-danger">*</span></label>
        <select name="sexe" class="form-select @error('sexe') is-invalid @enderror" required>
            <option value="">-- Choisir --</option>
            <option value="M" {{ old('sexe', $eleve->sexe ?? '') == 'M' ? 'selected' : '' }}>Masculin</option>
            <option value="F" {{ old('sexe', $eleve->sexe ?? '') == 'F' ? 'selected' : '' }}>Féminin</option>
        </select>
        @error('sexe')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Classe <span class="text-danger">*</span></label>
        <select name="classe_id" class="form-select @error('classe_id') is-invalid @enderror" required>
            <option value="">-- Choisir --</option>
            @foreach($classes as $classe)
                <option value="{{ $classe->id }}"
                    {{ old('classe_id', $eleve->classe_id ?? '') == $classe->id ? 'selected' : '' }}>
                    {{ $classe->nom }}
                </option>
            @endforeach
        </select>
        @error('classe_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Nom du parent / tuteur</label>
        <input type="text" name="nom_parent"
               class="form-control @error('nom_parent') is-invalid @enderror"
               value="{{ old('nom_parent', $eleve->nom_parent ?? '') }}">
        @error('nom_parent')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Téléphone</label>
        <input type="text" name="telephone_parent"
               class="form-control @error('telephone_parent') is-invalid @enderror"
               value="{{ old('telephone_parent', $eleve->telephone_parent ?? '') }}">
        @error('telephone_parent')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-6">
        <label class="form-label fw-semibold">Photo</label>
        @if(isset($eleve) && $eleve->photo)
            <div class="mb-2">
                <img src="{{ asset('storage/'.$eleve->photo) }}" class="rounded"
                     style="height:64px;width:64px;object-fit:cover">
                <small class="text-muted ms-2">Photo actuelle</small>
            </div>
        @endif
        <input type="file" name="photo"
               class="form-control @error('photo') is-invalid @enderror"
               accept="image/*">
        <small class="text-muted">JPG, PNG — max 2 Mo</small>
        @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>