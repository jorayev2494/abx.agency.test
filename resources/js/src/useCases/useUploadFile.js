import {ref} from "vue";

export const useUploadFile = () => {
  const uploadedFile = ref(null);

  const uploadFile = event => {
    const [file] = event.target.files;

    uploadedFile.value = file
  }

  return {
    uploadedFile,
    uploadFile,
  }
}
