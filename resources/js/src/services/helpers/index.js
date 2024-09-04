import { store } from '../store/index'

export const isMe = ({ uuid }) => uuid === store.getters['auth/getAuthData']?.uuid;
