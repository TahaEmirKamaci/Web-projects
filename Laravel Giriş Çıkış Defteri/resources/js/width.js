document.getElementById('formFile').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file && file.type.match('image./*')) {
        const reader = new FileReader();

        reader.onload = function(e) {
            const img = new Image();
            img.src = e.target.result;

            img.onload = function() {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                // Oranı belirleyin (örneğin, %50 küçültme)
                canvas.width =  200 ;
                canvas.height = 200 ;

                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                const resizedImageURL = canvas.toDataURL('image/jpeg');

                const imgElement = document.createElement('img');
                imgElement.src = resizedImageURL;
                imgElement.alt = "Küçültülmüş Görsel";
                imgElement.style.marginTop = '0px'; // Boşluk ekleyin
                imgElement.style.maxWidth = '100%';  // Ekrana tam oturması için max-width ayarlayın

                // Küçültülmüş resmi bir container'a ekleyin
                const imageContainer = document.getElementById('imageContainer');
                imageContainer.innerHTML = ''; // Eski resimleri temizleyin
                imageContainer.appendChild(imgElement);
            }
        }

        reader.readAsDataURL(file);
    }
});
