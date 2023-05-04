import { Ref, ref } from 'vue';

interface ImagePreview {
    preview: Ref<string | ArrayBuffer | undefined | null>;
    updatePreview: () => void;
    clearPreview: () => void;
}

export const useImagePreview = (input: Ref<HTMLInputElement | undefined>): ImagePreview => {
    const preview = ref<string | ArrayBuffer | undefined | null>(null);

    return {
        preview,
        updatePreview: () => {
            const photo = input.value?.files ? input.value?.files[0] : null;

            if (!photo) return;

            const reader = new FileReader();

            reader.onload = (e: ProgressEvent<FileReader>) => {
                preview.value = e.target?.result;
            };

            reader.readAsDataURL(photo);
        },
        clearPreview: () => {
            preview.value = null;
        }
    }
}