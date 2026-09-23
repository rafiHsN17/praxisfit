document.addEventListener('DOMContentLoaded', () => {
    const profileForm = document.getElementById('profile-form');
    
    // Result Elements
    const resProtein = document.getElementById('res-protein');
    const resBmr = document.getElementById('res-bmr');
    const resTdee = document.getElementById('res-tdee');

    // Load existing data if available
    function loadSavedProfile() {
        const savedData = localStorage.getItem('profileData');
        if (savedData) {
            const data = JSON.parse(savedData);
            
            // Populate form
            document.getElementById('gender').value = data.gender;
            document.getElementById('age').value = data.age;
            document.getElementById('weight').value = data.weight;
            document.getElementById('height').value = data.height;
            document.getElementById('activity').value = data.activity;

            // Display results
            updateResultUI(data.bmr, data.tdee, data.proteinTarget);
        }
    }

    function updateResultUI(bmr, tdee, protein) {
        resBmr.textContent = Math.round(bmr);
        resTdee.textContent = Math.round(tdee);
        resProtein.textContent = protein;
    }

    profileForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const gender = document.getElementById('gender').value;
        const age = parseInt(document.getElementById('age').value);
        const weight = parseFloat(document.getElementById('weight').value);
        const height = parseFloat(document.getElementById('height').value);
        const activity = parseFloat(document.getElementById('activity').value);

        let bmr = 0;

        // Mifflin-St Jeor Equation
        if (gender === 'male') {
            bmr = (10 * weight) + (6.25 * height) - (5 * age) + 5;
        } else {
            bmr = (10 * weight) + (6.25 * height) - (5 * age) - 161;
        }

        const tdee = bmr * activity;
        
        // Muscle building protein target: weight(kg) * 2.0g
        const proteinTarget = parseFloat((weight * 2.0).toFixed(1));

        // Update UI
        updateResultUI(bmr, tdee, proteinTarget);

        // Save to localStorage
        const profileData = { gender, age, weight, height, activity, bmr, tdee, proteinTarget };
        localStorage.setItem('profileData', JSON.stringify(profileData));
        localStorage.setItem('proteinTarget', proteinTarget);

        alert("Profil berhasil disimpan! Target protein harian Anda kini diperbarui di seluruh aplikasi.");
    });

    // Init
    loadSavedProfile();
});
