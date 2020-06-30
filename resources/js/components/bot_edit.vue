<template>
    <div class="wrapper" @mousemove="move($event)" @mouseup="moveStop()" @mouseleave="moveStop()" onselectstart="return false;">
        <!-- Sidebar  -->
        <side :sel="'home'"></side>
        <!-- Page Content  -->
        <div id="content">
            <head_main></head_main>
            <div class="content">
                <div class="content-options bg-dark text-white" :class="{'content-options-hide': !right_options}">
                    <div class="content-options-head">
                        <form v-on:submit.prevent>
                            <div class="form-group">
                                <button class="content-options-btn btn btn-success w-auto rounded-0 border-0" @click="right_options = false">Закрыть <i class="fas fa-arrow-right"></i></button>
                            </div>
                        </form>
                        <template v-for="(chain,index) in bot.chain">
                            <form class="content-options-form" v-show="(chain.type === 'start') && (index === options_id)" v-on:submit.prevent>
                                <div class="form-group">
                                    <label class="h6">Простое сообщение</label>
                                    <textarea class="form-control content-options-form-area rounded-0 border-0" rows="3" v-model="chain.message"></textarea>
                                </div>
                                <hr class="bg-secondary">
                                <div class="form-group">
                                    <label class="h6">Валидация</label>
                                    <select class="form-control rounded-0 border-0" v-model="chain.validation" :change="chain.validationData = template.validation[ chain.validation ].format">
                                        <option v-for="valid in template.validation" :value="valid.type" >{{valid.title}}</option>
                                    </select>
                                </div>
                                <hr class="bg-secondary">
                                <template v-if="chain.validation === 1 || chain.validation === 2 || chain.validation === 3 || chain.validation === 4">
                                    <div class="form-group">
                                        <label class="h6">Количество символов</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" :id="'check-'+index+'-1'" v-model="chain.validationData.status">
                                            <label class="form-check-label h6" :for="'check-'+index+'-1'">
                                                Ограничить количество символов
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group" v-if="chain.validationData.status">
                                        <label class="h6">Минимальное количество символов</label>
                                        <input type="number" class="form-control rounded-0 border-0" v-model="chain.validationData.min" :placeholder="chain.validationData.min">
                                    </div>
                                    <div class="form-group" v-if="chain.validationData.status">
                                        <label class="h6">Максимальное количество символов</label>
                                        <input type="number" class="form-control rounded-0 border-0" v-model="chain.validationData.max" :placeholder="chain.validationData.max">
                                    </div>
                                    <div class="form-group" v-if="chain.validationData.status">
                                        <label class="h6">Сообщение об ошибке количества символов</label>
                                        <textarea class="form-control content-options-form-area rounded-0 border-0" rows="3">{{chain.validationData.error}}</textarea>
                                    </div>
                                    <hr class="bg-secondary">
                                </template>
                                <template v-if="chain.validation === 5">
                                    <div class="form-group">
                                        <label class="h6">От</label>
                                        <input type="number" class="form-control rounded-0 border-0" v-model="chain.validationData.min" :placeholder="chain.validationData.min">
                                    </div>
                                    <div class="form-group">
                                        <label class="h6">До</label>
                                        <input type="number" class="form-control rounded-0 border-0" v-model="chain.validationData.max" :placeholder="chain.validationData.max">
                                    </div>
                                    <hr class="bg-secondary">
                                </template>
                                <template v-if="chain.validation === 6">
                                    <div class="form-group">
                                        <label class="h6">Формат даты / времени</label>
                                        <input class="form-control rounded-0 border-0" type="datetime-local" :placeholder="chain.validationData.date" v-model="chain.validationData.date">
                                    </div>
                                    <hr class="bg-secondary">
                                </template>
                                <template v-if="chain.validation === 7 || chain.validation === 8 || chain.validation === 9">
                                    <div class="form-group">
                                        <label class="h6">Сообщение об ошибке</label>
                                        <textarea class="form-control content-options-form-area rounded-0 border-0" rows="3">{{chain.validationData.error}}</textarea>
                                    </div>
                                    <hr class="bg-secondary">
                                </template>
                                <template v-if="chain.validation === 10">
                                    <div class="form-group">
                                        <label class="h6">Шаблон</label>
                                        <input class="form-control rounded-0 border-0" type="text" v-model="chain.validationData.template">
                                    </div>
                                    <div class="form-group">
                                        <label class="h6">Сообщение об ошибке</label>
                                        <textarea class="form-control content-options-form-area rounded-0 border-0" rows="3">{{chain.validationData.error}}</textarea>
                                    </div>
                                    <hr class="bg-secondary">
                                </template>
                                <div class="form-group">
                                    <label class="h6">Меню</label>
                                    <template v-for="(answer, id) in chain.answers">
                                        <div class="input-group mb-2" v-if="answer.type === 'custom'">
                                            <input type="text" class="form-control rounded-0 border-0" v-model="answer.title">
                                            <button class="btn content-options-btn-flex btn-danger rounded-0 border-0" @click="deleteAnswer(index, id)">Удалить</button>
                                        </div>
                                        <div class="input-group my-2" v-if="answer.type === 'default'">
                                            <input type="text" class="form-control rounded-0 border-0" v-model="answer.title" readonly>
                                        </div>
                                    </template>
                                    <div class="input-group my-2">
                                        <button class="btn content-options-btn-flex btn-success rounded-0 border-0" @click="addAnswer(index)"><i class="fas fa-plus"></i> Добавить ответ</button>
                                    </div>
                                </div>
                                <hr class="bg-secondary">
                                <div class="form-group">
                                    <label class="h6">Уведомление об ошибка</label>
                                    <textarea class="form-control content-options-form-area rounded-0 border-0" rows="3">{{chain.error}}</textarea>
                                </div>
                                <hr class="bg-secondary">
                                <div class="form-group">
                                    <label class="h6">Имя блока</label>
                                    <input type="text" class="form-control rounded-0 border-0" v-model="chain.name">
                                </div>
                            </form>
                            <form class="content-options-form" v-show="(chain.type === 'message') && (index === options_id)" v-on:submit.prevent>
                                <div class="form-group">
                                    <label class="h6">Простое сообщение</label>
                                    <textarea class="form-control content-options-form-area rounded-0 border-0" rows="3" v-model="chain.message"></textarea>
                                </div>
                                <hr class="bg-secondary">
                                <div class="form-group">
                                    <label class="h6">Валидация</label>
                                    <select class="form-control rounded-0 border-0" v-model="chain.validation" :change="chain.validationData = template.validation[ chain.validation ].format">
                                        <option v-for="valid in template.validation" :value="valid.type" >{{valid.title}}</option>
                                    </select>
                                </div>
                                <hr class="bg-secondary">
                                <template v-if="chain.validation === 1 || chain.validation === 2 || chain.validation === 3 || chain.validation === 4">
                                    <div class="form-group">
                                        <label class="h6">Количество символов</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" :id="'check-'+index+'-1'" v-model="chain.validationData.status">
                                            <label class="form-check-label h6" :for="'check-'+index+'-1'">
                                                Ограничить количество символов
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group" v-if="chain.validationData.status">
                                        <label class="h6">Минимальное количество символов</label>
                                        <input type="number" class="form-control rounded-0 border-0" v-model="chain.validationData.min" :placeholder="chain.validationData.min">
                                    </div>
                                    <div class="form-group" v-if="chain.validationData.status">
                                        <label class="h6">Максимальное количество символов</label>
                                        <input type="number" class="form-control rounded-0 border-0" v-model="chain.validationData.max" :placeholder="chain.validationData.max">
                                    </div>
                                    <div class="form-group" v-if="chain.validationData.status">
                                        <label class="h6">Сообщение об ошибке количества символов</label>
                                        <textarea class="form-control content-options-form-area rounded-0 border-0" rows="3">{{chain.validationData.error}}</textarea>
                                    </div>
                                    <hr class="bg-secondary">
                                </template>
                                <template v-if="chain.validation === 5">
                                    <div class="form-group">
                                        <label class="h6">От</label>
                                        <input type="number" class="form-control rounded-0 border-0" v-model="chain.validationData.min" :placeholder="chain.validationData.min">
                                    </div>
                                    <div class="form-group">
                                        <label class="h6">До</label>
                                        <input type="number" class="form-control rounded-0 border-0" v-model="chain.validationData.max" :placeholder="chain.validationData.max">
                                    </div>
                                    <hr class="bg-secondary">
                                </template>
                                <template v-if="chain.validation === 6">
                                    <div class="form-group">
                                        <label class="h6">Формат даты / времени</label>
                                        <input class="form-control rounded-0 border-0" type="datetime-local" :placeholder="chain.validationData.date" v-model="chain.validationData.date">
                                    </div>
                                    <hr class="bg-secondary">
                                </template>
                                <template v-if="chain.validation === 7 || chain.validation === 8 || chain.validation === 9">
                                    <div class="form-group">
                                        <label class="h6">Сообщение об ошибке</label>
                                        <textarea class="form-control content-options-form-area rounded-0 border-0" rows="3">{{chain.validationData.error}}</textarea>
                                    </div>
                                    <hr class="bg-secondary">
                                </template>
                                <template v-if="chain.validation === 10">
                                    <div class="form-group">
                                        <label class="h6">Шаблон</label>
                                        <input class="form-control rounded-0 border-0" type="text" v-model="chain.validationData.template">
                                    </div>
                                    <div class="form-group">
                                        <label class="h6">Сообщение об ошибке</label>
                                        <textarea class="form-control content-options-form-area rounded-0 border-0" rows="3">{{chain.validationData.error}}</textarea>
                                    </div>
                                    <hr class="bg-secondary">
                                </template>
                                <div class="form-group">
                                    <label class="h6">Меню</label>
                                    <template v-for="(answer, id) in chain.answers">
                                        <div class="input-group mb-2" v-if="answer.type === 'custom'">
                                            <input type="text" class="form-control rounded-0 border-0" v-model="answer.title">
                                            <button class="btn content-options-btn-flex btn-danger rounded-0 border-0" @click="deleteAnswer(index, id)">Удалить</button>
                                        </div>
                                        <div class="input-group my-2" v-if="answer.type === 'default'">
                                            <input type="text" class="form-control rounded-0 border-0" v-model="answer.title" readonly>
                                        </div>
                                    </template>
                                    <div class="input-group my-2">
                                        <button class="btn content-options-btn-flex btn-success rounded-0 border-0" @click="addAnswer(index)"><i class="fas fa-plus"></i> Добавить ответ</button>
                                    </div>
                                </div>
                                <hr class="bg-secondary">
                                <div class="form-group">
                                    <label class="h6">Уведомление об ошибка</label>
                                    <textarea class="form-control content-options-form-area rounded-0 border-0" rows="3">{{chain.error}}</textarea>
                                </div>
                                <hr class="bg-secondary">
                                <div class="form-group">
                                    <label class="h6">Имя блока</label>
                                    <input type="text" class="form-control rounded-0 border-0" v-model="chain.name">
                                </div>
                            </form>
                            <form class="content-options-form" v-show="(chain.type === 'chain') && (index === options_id)" v-on:submit.prevent>
                                <template v-for="(message,id) in chain.messages">
                                    <div class="form-group position-relative">
                                        <button class="btn position-absolute remove-btn bg-primary text-white h6 rounded-0 border-0" @click="removeText(index,id)"><i class="fas fa-trash-alt"></i></button>
                                        <textarea class="form-control content-options-form-area rounded-0 border-0" rows="3" v-model="message.title"></textarea>
                                    </div>
                                    <hr class="bg-secondary">
                                </template>

                                <template v-for="(photo,id) in chain.photos">
                                    <div class="form-group position-relative" v-if="!photo.ready">
                                        <div class="grid-button">
                                            <div v-if="!photo.status">
                                                <button class="btn btn-primary rounded-0 border-0 w-100" @click="photoFile(index,id)">Загрузить фото</button>
                                                <input type="file" :id="'photo'+index+'-'+id" :ref="'photo'+index+'_'+id" class="invisible" @change="photoUpload(index,id)" accept="image/jpeg,image/png,image/gif">
                                            </div>
                                            <div v-else>
                                                <div class="progress rounded-0 my-2">
                                                    <div class="progress-bar" role="progressbar" :aria-valuenow="photo.percent" aria-valuemin="0" aria-valuemax="100" :style="{width: photo.percent+'%'}">{{photo.percent}} %</div>
                                                </div>
                                            </div>
                                            <div>
                                                <button class="btn position-absolute bg-primary text-white h6 rounded-0 border-0" @click="removePhoto(index,id)"><i class="fas fa-trash-alt"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group position-relative" v-else>
                                        <button class="btn position-absolute remove-btn bg-primary text-white h6 rounded-0 border-0" @click="removePhoto(index,id)"><i class="fas fa-trash-alt"></i></button>
                                        <img :src="photo.format.url" class="img-thumbnail rounded-0">
                                        <button class="btn bg-transparent rounded-0 w-100 mt-3 text-white" @click="photoDescription(index,id)" v-if="!photo.description">Добавить описание</button>
                                        <textarea class="form-control content-options-form-area rounded-0 border-0 mt-3" rows="3" v-model="photo.text" v-else></textarea>
                                    </div>
                                    <hr class="bg-secondary">
                                </template>

                                <template v-for="(video,id) in chain.videos">
                                    <div class="form-group position-relative" v-if="!video.ready">
                                        <div class="grid-button">
                                            <div v-if="!video.status">
                                                <button class="btn btn-primary rounded-0 border-0 w-100" @click="videoFile(index,id)">Загрузить видео</button>
                                                <input type="file" :id="'video'+index+'-'+id" :ref="'video'+index+'_'+id" class="invisible" @change="videoUpload(index,id)" accept="video/mp4">
                                            </div>
                                            <div v-else>
                                                <div class="progress rounded-0 my-2">
                                                    <div class="progress-bar" role="progressbar" :aria-valuenow="video.percent" aria-valuemin="0" aria-valuemax="100" :style="{width: video.percent+'%'}">{{video.percent}} %</div>
                                                </div>
                                            </div>
                                            <div>
                                                <button class="btn position-absolute bg-primary text-white h6 rounded-0 border-0" @click="removeVideo(index,id)"><i class="fas fa-trash-alt"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group position-relative" v-else>
                                        <button class="btn position-absolute remove-btn bg-primary text-white h6 rounded-0 border-0" @click="removeVideo(index,id)"><i class="fas fa-trash-alt"></i></button>
                                        <video controls :src="video.format.url" width="100%"></video>
                                        <button class="btn bg-transparent rounded-0 w-100 mt-3 text-white" @click="videoDescription(index,id)" v-if="!video.description">Добавить описание</button>
                                        <textarea class="form-control content-options-form-area rounded-0 border-0 mt-3" rows="3" v-model="video.text" v-else></textarea>
                                    </div>
                                    <hr class="bg-secondary">
                                </template>

                                <template v-for="(document,id) in chain.documents">
                                    <div class="form-group position-relative" v-if="!document.ready">
                                        <div class="grid-button">
                                            <div v-if="!document.status">
                                                <button class="btn btn-primary rounded-0 border-0 w-100" @click="documentFile(index,id)">Загрузить документ</button>
                                                <input type="file" :id="'document'+index+'-'+id" :ref="'document'+index+'_'+id" class="invisible" @change="documentUpload(index,id)" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
text/plain, application/pdf, image/*">
                                            </div>
                                            <div v-else>
                                                <div class="progress rounded-0 my-2">
                                                    <div class="progress-bar" role="progressbar" :aria-valuenow="document.percent" aria-valuemin="0" aria-valuemax="100" :style="{width: document.percent+'%'}">{{document.percent}} %</div>
                                                </div>
                                            </div>
                                            <div>
                                                <button class="btn position-absolute bg-primary text-white h6 rounded-0 border-0" @click="removeDocument(index,id)"><i class="fas fa-trash-alt"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group position-relative" v-else>
                                        <button class="btn position-absolute remove-btn bg-primary text-white h6 rounded-0 border-0" @click="removeDocument(index,id)" style="z-index: 10;"><i class="fas fa-trash-alt"></i></button>
                                        <a :href="document.format.url" target="_blank" download>
                                            <button class="btn bg-light w-100 rounded-0">{{document.format.name}}</button>
                                        </a>
                                        <button class="btn bg-transparent rounded-0 w-100 mt-3 text-white" @click="documentDescription(index,id)" v-if="!document.description">Добавить описание</button>
                                        <textarea class="form-control content-options-form-area rounded-0 border-0 mt-3" rows="3" v-model="document.text" v-else></textarea>
                                    </div>
                                    <hr class="bg-secondary">
                                </template>

                                <template v-for="(sound,id) in chain.sounds">
                                    <div class="form-group position-relative" v-if="!sound.ready">
                                        <div class="grid-button">
                                            <div v-if="!sound.status">
                                                <button class="btn btn-primary rounded-0 border-0 w-100" @click="soundFile(index,id)">Загрузить звук</button>
                                                <input type="file" :id="'sound'+index+'-'+id" :ref="'sound'+index+'_'+id" class="invisible" @change="soundUpload(index,id)" accept="audio/mp3">
                                            </div>
                                            <div v-else>
                                                <div class="progress rounded-0 my-2">
                                                    <div class="progress-bar" role="progressbar" :aria-valuenow="sound.percent" aria-valuemin="0" aria-valuemax="100" :style="{width: sound.percent+'%'}">{{sound.percent}} %</div>
                                                </div>
                                            </div>
                                            <div>
                                                <button class="btn position-absolute bg-primary text-white h6 rounded-0 border-0" @click="removeSound(index,id)"><i class="fas fa-trash-alt"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group position-relative" v-else>
                                        <button class="btn position-absolute remove-btn bg-primary text-white h6 rounded-0 border-0" @click="removeSound(index,id)" style="z-index: 10;"><i class="fas fa-trash-alt"></i></button>
                                        <audio :src="sound.format.url" controls width="100%" style="width: 424px;border-radius: 0 !important;background: #f1f3f4;"></audio>
                                        <button class="btn bg-transparent rounded-0 w-100 mt-3 text-white" @click="soundDescription(index,id)" v-if="!sound.description">Добавить описание</button>
                                        <textarea class="form-control content-options-form-area rounded-0 border-0 mt-3" rows="3" v-model="sound.text" v-else></textarea>
                                    </div>
                                    <hr class="bg-secondary">
                                </template>

                                <template v-for="(audio,id) in chain.audios">
                                    <div class="form-group position-relative" v-if="!audio.ready">
                                        <div class="grid-button">
                                            <div v-if="!audio.status">
                                                <button class="btn btn-primary rounded-0 border-0 w-100" @click="audioFile(index,id)">Загрузить аудио</button>
                                                <input type="file" :id="'audio'+index+'-'+id" :ref="'audio'+index+'_'+id" class="invisible" @change="audioUpload(index,id)" accept="audio/ogg">
                                            </div>
                                            <div v-else>
                                                <div class="progress rounded-0 my-2">
                                                    <div class="progress-bar" role="progressbar" :aria-valuenow="audio.percent" aria-valuemin="0" aria-valuemax="100" :style="{width: audio.percent+'%'}">{{audio.percent}} %</div>
                                                </div>
                                            </div>
                                            <div>
                                                <button class="btn position-absolute bg-primary text-white h6 rounded-0 border-0" @click="removeAudio(index,id)"><i class="fas fa-trash-alt"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group position-relative" v-else>
                                        <button class="btn position-absolute remove-btn bg-primary text-white h6 rounded-0 border-0" @click="removeAudio(index,id)" style="z-index: 10;"><i class="fas fa-trash-alt"></i></button>
                                        <audio :src="audio.format" controls width="100%" style="width: 424px;border-radius: 0 !important;background: #f1f3f4;"></audio>
                                        <button class="btn bg-transparent rounded-0 w-100 mt-3 text-white" @click="audioDescription(index,id)" v-if="!audio.description">Добавить описание</button>
                                        <textarea class="form-control content-options-form-area rounded-0 border-0 mt-3" rows="3" v-model="audio.text" v-else></textarea>
                                    </div>
                                    <hr class="bg-secondary">
                                </template>

                                <div class="form-group">
                                    <label class="h6">Цепочка сообщении</label>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <button class="btn w-100 btn-primary border-0 rounded-0" @click="chainText(index)">
                                            <i class="fas fa-comments"></i> Текст
                                        </button>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <button class="btn w-100 btn-primary border-0 rounded-0" @click="chainPhoto(index)">
                                            <i class="fas fa-images"></i> Фото
                                        </button>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <button class="btn w-100 btn-primary border-0 rounded-0" @click="chainVideo(index)">
                                            <i class="fas fa-video"></i> Видео
                                        </button>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <button class="btn w-100 btn-primary border-0 rounded-0" @click="chainDocument(index)">
                                            <i class="fas fa-file"></i> Файл
                                        </button>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <button class="btn w-100 btn-primary border-0 rounded-0" @click="chainAudio(index)">
                                            <i class="fas fa-volume-up"></i> Аудио
                                        </button>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <button class="btn w-100 btn-primary border-0 rounded-0" @click="chainSound(index)">
                                            <i class="fas fa-music"></i> Звук
                                        </button>
                                    </div>
                                </div>
                                <hr class="bg-secondary">
                                <div class="form-group">
                                    <label class="h6">Валидация</label>
                                    <select class="form-control rounded-0 border-0" v-model="chain.validation" :change="chain.validationData = template.validation[ chain.validation ].format">
                                        <option v-for="valid in template.validation" :value="valid.type" >{{valid.title}}</option>
                                    </select>
                                </div>
                                <hr class="bg-secondary">
                                <template v-if="chain.validation === 1 || chain.validation === 2 || chain.validation === 3 || chain.validation === 4">
                                    <div class="form-group">
                                        <label class="h6">Количество символов</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" :id="'check-'+index+'-1'" v-model="chain.validationData.status">
                                            <label class="form-check-label h6" :for="'check-'+index+'-1'">
                                                Ограничить количество символов
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group" v-if="chain.validationData.status">
                                        <label class="h6">Минимальное количество символов</label>
                                        <input type="number" class="form-control rounded-0 border-0" v-model="chain.validationData.min" :placeholder="chain.validationData.min">
                                    </div>
                                    <div class="form-group" v-if="chain.validationData.status">
                                        <label class="h6">Максимальное количество символов</label>
                                        <input type="number" class="form-control rounded-0 border-0" v-model="chain.validationData.max" :placeholder="chain.validationData.max">
                                    </div>
                                    <div class="form-group" v-if="chain.validationData.status">
                                        <label class="h6">Сообщение об ошибке количества символов</label>
                                        <textarea class="form-control content-options-form-area rounded-0 border-0" rows="3">{{chain.validationData.error}}</textarea>
                                    </div>
                                    <hr class="bg-secondary">
                                </template>
                                <template v-if="chain.validation === 5">
                                    <div class="form-group">
                                        <label class="h6">От</label>
                                        <input type="number" class="form-control rounded-0 border-0" v-model="chain.validationData.min" :placeholder="chain.validationData.min">
                                    </div>
                                    <div class="form-group">
                                        <label class="h6">До</label>
                                        <input type="number" class="form-control rounded-0 border-0" v-model="chain.validationData.max" :placeholder="chain.validationData.max">
                                    </div>
                                    <hr class="bg-secondary">
                                </template>
                                <template v-if="chain.validation === 6">
                                    <div class="form-group">
                                        <label class="h6">Формат даты / времени</label>
                                        <input class="form-control rounded-0 border-0" type="datetime-local" :placeholder="chain.validationData.date" v-model="chain.validationData.date">
                                    </div>
                                    <hr class="bg-secondary">
                                </template>
                                <template v-if="chain.validation === 7 || chain.validation === 8 || chain.validation === 9">
                                    <div class="form-group">
                                        <label class="h6">Сообщение об ошибке</label>
                                        <textarea class="form-control content-options-form-area rounded-0 border-0" rows="3">{{chain.validationData.error}}</textarea>
                                    </div>
                                    <hr class="bg-secondary">
                                </template>
                                <template v-if="chain.validation === 10">
                                    <div class="form-group">
                                        <label class="h6">Шаблон</label>
                                        <input class="form-control rounded-0 border-0" type="text" v-model="chain.validationData.template">
                                    </div>
                                    <div class="form-group">
                                        <label class="h6">Сообщение об ошибке</label>
                                        <textarea class="form-control content-options-form-area rounded-0 border-0" rows="3">{{chain.validationData.error}}</textarea>
                                    </div>
                                    <hr class="bg-secondary">
                                </template>
                                <div class="form-group">
                                    <label class="h6">Меню</label>
                                    <template v-for="(answer, id) in chain.answers">
                                        <div class="input-group mb-2" v-if="answer.type === 'custom'">
                                            <input type="text" class="form-control rounded-0 border-0" v-model="answer.title">
                                            <button class="btn content-options-btn-flex btn-danger rounded-0 border-0" @click="deleteAnswer(index, id)">Удалить</button>
                                        </div>
                                        <div class="input-group my-2" v-if="answer.type === 'default'">
                                            <input type="text" class="form-control rounded-0 border-0" v-model="answer.title" readonly>
                                        </div>
                                    </template>
                                    <div class="input-group my-2">
                                        <button class="btn content-options-btn-flex btn-success rounded-0 border-0" @click="addAnswer(index)"><i class="fas fa-plus"></i> Добавить ответ</button>
                                    </div>
                                </div>
                                <hr class="bg-secondary">
                                <div class="form-group">
                                    <label class="h6">Уведомление об ошибка</label>
                                    <textarea class="form-control content-options-form-area rounded-0 border-0" rows="3">{{chain.error}}</textarea>
                                </div>
                                <hr class="bg-secondary">
                                <div class="form-group">
                                    <label class="h6">Имя блока</label>
                                    <input type="text" class="form-control rounded-0 border-0" v-model="chain.name">
                                </div>
                            </form>
                        </template>
                    </div>
                </div>

                <div class="content-scheme">
                    <template v-for="(chain,index) in bot.chain">
                        <div class="content-scheme-item" v-if="chain.type === 'start'" :ref="'chain_'+index" :class="{ black: (Object.keys(chain.connected).length>0?true:false)}">
                            <div class="content-scheme-item-title">Старт</div>
                            <div class="content-scheme-item-body">
                                <div class="content-scheme-item-body-head" v-if="chain.name != null && chain.name != ''">
                                    <i class="fas fa-link"></i> {{chain.name}}
                                </div>
                                <div class="content-scheme-item-body-head" v-else>
                                    <i class="fas fa-link"></i> Цепочка событий
                                </div>
                                <div class="content-scheme-item-body-content" @click="options(index)">
                                    <button class="btn btn-success w-100 text-left" v-for="(answer,id) in chain.answers" :class="[answer.type === 'default' ? 'btn-dark' : 'btn-success']">
                                        <span>{{answer.title}}</span>
                                        <div class="content-scheme-item-node">
                                            <div class="content-scheme-item-node-icon" @mousedown="line($event, index, id)" :class="{black: answer.connect.active}" @click.stop>
                                                <div class="content-scheme-item-node-icon-center">
                                                    <svg :height="answer.connect.endHeight*2" :width="answer.connect.endWidth*2" v-show="answer.connect.active" class="svg" :style="{'top': '-'+answer.connect.endHeight, 'left': '-'+answer.connect.endWidth}">
                                                        <defs>
                                                            <marker :id="'chain_'+index+'-'+id" viewBox="0 0 25 25"
                                                                    refX="1" refY="5"
                                                                    markerUnits="strokeWidth"
                                                                    markerWidth="10" markerHeight="10"
                                                                    orient="auto">
                                                                <path d="M 0 0 L 10 5 L 0 10 z" fill="#000"/>
                                                            </marker>
                                                        </defs>
                                                        <path :d="'M '+answer.connect.endWidth+' '+answer.connect.endHeight+' L'+answer.connect.l1+' '+answer.connect.l2" stroke="black"  stroke-width="3" :marker-end="'url(#chain_'+index+'-'+id+')'"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="content-scheme-item-disabled content-scheme-item-add" v-if="chain.type === 'message'" :style="{ top: bot.chain[ index ].Y + 'px', left: bot.chain[ index ].X + 'px' }" :ref="'chain_'+index" :class="{ black: (Object.keys(chain.connected).length>0?true:false)}">
                            <div class="content-scheme-item-btn-list">
                                <div class="content-scheme-item-btn-copy">
                                    <i class="fas fa-copy"></i>
                                </div>
                                <div class="content-scheme-item-btn-delete" @click="deleteChain(index)">
                                    <i class="fas fa-trash-alt"></i>
                                </div>
                            </div>
                            <div class="content-scheme-item-body">
                                <div class="content-scheme-item-body-head" @mousedown="down($event, index)" @mouseleave="drag.status = false"><span v-if="chain.name != null && chain.name != ''"><i class="fas fa-comments"></i> {{chain.name}}</span><span v-else><i class="fas fa-comments"></i> Сообщение от бота</span></div>
                                <div class="content-scheme-item-body-content" @click="options(index)">
                                    <button class="btn w-100 text-left" v-for="(answer,id) in chain.answers" :class="[answer.type === 'default' ? 'btn-dark' : 'btn-success']">
                                        <span>{{answer.title}}</span>
                                        <div class="content-scheme-item-node content-scheme-item-node">
                                            <div class="content-scheme-item-node-icon" @mousedown="line($event, index, id)" :class="{black: answer.connect.active}">
                                                <div class="content-scheme-item-node-icon-center">
                                                    <svg :height="answer.connect.endHeight*2" :width="answer.connect.endWidth*2" v-show="answer.connect.active" class="svg" :style="{'top': '-'+answer.connect.endHeight, 'left': '-'+answer.connect.endWidth}">
                                                        <defs>
                                                            <marker :id="'chain_'+index+'-'+id" viewBox="0 0 25 25"
                                                                    refX="1" refY="5"
                                                                    markerUnits="strokeWidth"
                                                                    markerWidth="10" markerHeight="10"
                                                                    orient="auto">
                                                                <path d="M 0 0 L 10 5 L 0 10 z" fill="#000"/>
                                                            </marker>
                                                        </defs>
                                                        <path :d="'M '+answer.connect.endWidth+' '+answer.connect.endHeight+' L'+answer.connect.l1+' '+answer.connect.l2" stroke="black"  stroke-width="3" :marker-end="'url(#chain_'+index+'-'+id+')'"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="content-scheme-item-disabled content-scheme-item-chain" onselectstart="return false;" v-if="chain.type === 'chain'" :style="{ top: bot.chain[ index ].Y + 'px', left: bot.chain[ index ].X + 'px' }" :ref="'chain_'+index" :class="{ black: (Object.keys(chain.connected).length>0?true:false)}">
                            <div class="content-scheme-item-body">
                                <div class="content-scheme-item-body-head" @mousedown="down($event, index)" @mouseleave="drag.status = false"><span v-if="chain.name != null && chain.name != ''"><i class="fas fa-link"></i> {{chain.name}}</span><span v-else><i class="fas fa-link"></i> Цепочка сообщении</span></div>
                                <div class="content-scheme-item-body-content" @click="options(index)">
                                    <button class="btn w-100 text-left" v-for="(answer,id) in chain.answers" :class="[answer.type === 'default' ? 'btn-dark' : 'btn-success']">

                                        <span>{{answer.title}}</span>
                                        <div class="content-scheme-item-node">
                                            <div class="content-scheme-item-node-icon" @mousedown="line($event, index, id)" :class="{black: answer.connect.active}" @click.stop>
                                                <div class="content-scheme-item-node-icon-center">
                                                    <svg :height="answer.connect.endHeight*2" :width="answer.connect.endWidth*2" v-show="answer.connect.active" class="svg" :style="{'top': '-'+answer.connect.endHeight, 'left': '-'+answer.connect.endWidth}">
                                                        <defs>
                                                            <marker :id="'chain_'+index+'-'+id" viewBox="0 0 25 25"
                                                                    refX="1" refY="5"
                                                                    markerUnits="strokeWidth"
                                                                    markerWidth="10" markerHeight="10"
                                                                    orient="auto">
                                                                <path d="M 0 0 L 10 5 L 0 10 z" fill="#f00"/>
                                                            </marker>
                                                        </defs>
                                                        <path :d="'M '+answer.connect.endWidth+' '+answer.connect.endHeight+' L'+answer.connect.l1+' '+answer.connect.l2" stroke="red"  stroke-width="3" :marker-end="'url(#chain_'+index+'-'+id+')'"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                    <div class="content-new-list" v-if="editId == 0">
                        <div class="content-new-block" @click="modal = true"><i class="fas fa-plus"></i> Добавить блок</div>
                        <div class="content-new-publish" @click="newBot = true">Опубликовать бота</div>
                        <div class="content-new-publish bg-danger" @click="clearBot()">Очистить бота</div>
                    </div>
                    <div class="content-new-list" v-else>
                        <div class="content-new-block" @click="modal = true"><i class="fas fa-plus"></i> Добавить блок</div>
                        <div class="content-new-publish" @click="newBot = true">Сохранить</div>
                    </div>
                    <div class="content-modal" :class="{ 'content-modal-show': newBot }">
                        <div class="content-modal-body">
                            <div class="content-modal-close" @click="newBot = false"></div>
                            <div class="content-modal-body-in">
                                <form v-on:submit.prevent>
                                    <div class="form-group">
                                        <label>Название бота</label>
                                        <input type="text" ref="bot" v-model="botName" class="form-control" >
                                    </div>
                                    <button type="submit" class="btn btn-primary" @click="createBot()" v-if="editId == 0">Создать бота</button>
                                    <button type="submit" class="btn btn-primary" @click="saveEditBot()" v-else>Сохранить изменение</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="content-modal" :class="{ 'content-modal-show': modal }">
                        <div class="content-modal-body">
                            <div class="content-modal-close" @click="modal = false"></div>
                            <div class="content-modal-body-in">
                                <div class="content-modal-body-item" @click="addChain(0)">
                                    <div>
                                        <i class="fas fa-comments"></i>
                                    </div>
                                    <div>
                                        <div>Простое сообщение</div>
                                        <div>Простое текстовое сообщение</div>
                                    </div>
                                </div>
                                <div class="content-modal-body-item" @click="addChain(1)">
                                    <div>
                                        <i class="fas fa-link"></i>
                                    </div>
                                    <div>
                                        <div>Цепочка сообщении</div>
                                        <div>Отправляется последовательно и может состоять из текста, фото, видео, аудио, документа</div>
                                    </div>
                                </div>
                                <div class="content-modal-body-item bg-danger">
                                    <div>
                                        <i class="fas fa-greater-than-equal"></i>
                                    </div>
                                    <div>
                                        <div>Условие</div>
                                        <div>Разделение сценария на две ветки в соответствии с заданным условием</div>
                                    </div>
                                </div>
                                <div class="content-modal-body-item bg-primary">
                                    <div>
                                        <i class="fas fa-server"></i>
                                    </div>
                                    <div>
                                        <div>тение записей из списка</div>
                                        <div>Чтение записи из списка, созданного в разделе Списки</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import side from './sidebar';
    import head_main from './head';
    export default {
        props: ['editId'],
        components: {
            side,
            head_main
        },
        name: "bot_edit",
        data: function() {
            return {
                right_options: false,
                options_id: -1,
                modal: false,
                newBot: false,
                botName: '',
                bot: {
                    chain: [],
                },
                template: {
                    validation: [
                        {
                            type: 0,
                            title: 'Нет',
                            format: {

                            }
                        },
                        {
                            type: 1,
                            title: 'Текст',
                            format: {
                                status: false,
                                min: 0,
                                max: 10,
                                error: '',
                            }
                        },
                        {
                            type: 2,
                            title: 'Цифры',
                            format: {
                                status: false,
                                min: 0,
                                max: 10,
                                error: '',
                            }
                        },
                        {
                            type: 3,
                            title: 'Буквы',
                            format: {
                                status: false,
                                min: 0,
                                max: 10,
                                error: '',
                            }
                        },
                        {
                            type: 4,
                            title: 'Буквы и цифры',
                            format: {
                                status: false,
                                min: 0,
                                max: 10,
                                error: '',
                            }
                        },
                        {
                            type: 5,
                            title: 'Диапозон чисел',
                            format: {
                                date: '',
                            }
                        },
                        {
                            type: 6,
                            title: 'Дата и время',
                            format: {
                                template: 'd-m-Y H:i:s'
                            }
                        },
                        {
                            type: 7,
                            title: 'Номер телефона',
                            format: {
                                error: ''
                            }
                        },
                        {
                            type: 8,
                            title: 'Email',
                            format: {
                                error: ''
                            }
                        },
                        {
                            type: 9,
                            title: 'URL',
                            format: {
                                error: ''
                            }
                        },
                        {
                            type: 10,
                            title: 'Регулярное выражение',
                            format: {
                                template: '^[a-z0-9]+$',
                                error: ''
                            }
                        }
                    ],
                    answer: {
                        title: 'Привет',
                        type: 'custom',
                        connect: {
                            status: false,
                            active: false,
                            block: -1,
                            l1: 0,
                            l2: 0,
                            endWidth: 0,
                            endHeight: 0,
                        }
                    },
                    default: {
                        title: 'Любая другая фраза',
                        type: 'default',
                        connect: {
                            status: false,
                            active: false,
                            block: -1,
                            l1: 0,
                            l2: 0,
                            endWidth: 0,
                            endHeight: 0,
                        }
                    },
                    start: {
                        type: 'start',
                        message: '',
                        validation: 0,
                        status: false,
                        name: '',
                        error: '',
                        connected: {},
                        answers: [],
                        Y: 30,
                        X: 30,
                    },
                    message: {
                        type: 'message',
                        message: '',
                        validation: 0,
                        status: false,
                        name: '',
                        error: '',
                        connected: {},
                        answers: [],
                        Y: 30,
                        X: 340,
                    },
                    messageChain: {
                        type: 'chain',
                        messages: [],
                        photos: [],
                        videos: [],
                        audios: [],
                        sounds: [],
                        documents: [],
                        validation: 0,
                        validationData: {},
                        status: false,
                        name: '',
                        error: '',
                        connected: {},
                        answers: [],
                        Y: 30,
                        X: 340,
                    },
                    condition: {

                    },
                    list: {

                    },
                    photo: {
                        file: '',
                        format: '',
                        status: false,
                        ready: false,
                        description: false,
                        percent: 0,
                        text: '',
                    },
                    video: {
                        file: '',
                        format: '',
                        status: false,
                        ready: false,
                        description: false,
                        percent: 0,
                        text: '',
                    },
                    sound: {
                        file: '',
                        format: '',
                        status: false,
                        ready: false,
                        description: false,
                        percent: 0,
                        text: '',
                    },
                    audio: {
                        file: '',
                        format: '',
                        status: false,
                        ready: false,
                        description: false,
                        percent: 0,
                        text: '',
                    },
                    document: {
                        file: '',
                        format: {
                            url: '',
                            name: '',
                        },
                        status: false,
                        ready: false,
                        description: false,
                        percent: 0,
                        text: '',
                    }
                },
                drag: {
                    status: false,
                    index: 0,
                    Y: 0,
                    X: 0
                }
            }
        },
        mounted() {
            this.template.start.answers.push( JSON.parse(JSON.stringify(this.template.default)) );
            this.template.message.answers.push( JSON.parse(JSON.stringify(this.template.default)) );
            this.template.messageChain.answers.push( JSON.parse(JSON.stringify(this.template.default)) );
            this.template.start.answers.push( JSON.parse(JSON.stringify(this.template.answer)) );
            if (this.editId == 0) {
                if (localStorage.chain) {
                    this.bot.chain = JSON.parse(localStorage.chain);
                } else {

                    this.bot.chain.push( JSON.parse(JSON.stringify(this.template.start)) );
                    localStorage.chain = JSON.stringify(this.bot.chain);
                }
            } else {

                let self = this;
                axios.get('/ajax/edit/bot/'+this.editId).then(function (response) {
                    if (response.data.length === 0) {
                        return window.location.href = '/analyze';
                    }
                    let name = response.data.splice(0,1);
                    self.botName = name[0];
                    response.data.forEach(function callback(currentValue, index, array) {
                        self.bot.chain.push( currentValue);
                    });
                })
                .catch(function (error) {
                    console.log(error);
                })
            }
        },
        methods: {
            clearBot() {
                localStorage.removeItem('chain');
                this.bot.chain = [];
                this.bot.chain.push( JSON.parse(JSON.stringify(this.template.start)) );
            },
            removeText(index, id) {
                this.bot.chain[ index ].messages.splice(id,1);
            },
            chainText(index) {
                this.bot.chain[ index ].messages.push({'title':''});
            },
            removePhoto(index, id) {
                this.bot.chain[ index ].photos.splice(id,1);
            },
            photoFile(index,id) {
                document.getElementById('photo'+index+'-'+id).click();
            },
            photoDescription(index,id) {
                this.bot.chain[ index ].photos[ id ].description = true;
            },
            photoUpload(index,id) {
                this.bot.chain[ index ].photos[ id ].status = true;
                this.bot.chain[ index ].photos[ id ].file = document.getElementById('photo'+index+'-'+id).files[0];
                let data = this.data('photo', this.bot.chain[ index ].photos[ id ].file );
                let self = this;

                axios.post( '/photo-upload',
                    data,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        onUploadProgress: function(progressEvent) {
                            self.bot.chain[ index ].photos[ id ].percent = parseInt(( progressEvent.loaded / progressEvent.total) * 100);
                        }
                    }
                )
                    .then(function(response) {
                        console.log(response.data);
                        self.bot.chain[ index ].photos[ id ].ready = true;
                        self.bot.chain[ index ].photos[ id ].format = response.data;
                    })
                    .catch(function(){
                        console.log('FAILURE PHOTO UPLOAD!!');
                    });

            },
            chainPhoto(index) {
                this.bot.chain[ index ].photos.push( JSON.parse(JSON.stringify(this.template.photo)) );
            },
            removeVideo(index, id) {
                this.bot.chain[ index ].videos.splice(id,1);
            },
            videoFile(index,id) {
                document.getElementById('video'+index+'-'+id).click();
            },
            videoDescription(index,id) {
                this.bot.chain[ index ].videos[ id ].description = true;
            },
            videoUpload(index,id) {
                this.bot.chain[ index ].videos[ id ].status = true;
                this.bot.chain[ index ].videos[ id ].file = document.getElementById('video'+index+'-'+id).files[0];
                let data = this.data('video', this.bot.chain[ index ].videos[ id ].file );
                let self = this;

                axios.post( '/video-upload',
                    data,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        onUploadProgress: function(progressEvent) {
                            self.bot.chain[ index ].videos[ id ].percent = parseInt(( progressEvent.loaded / progressEvent.total) * 100);
                        }
                    }
                )
                    .then(function(response) {
                        console.log(response.data);
                        self.bot.chain[ index ].videos[ id ].ready = true;
                        self.bot.chain[ index ].videos[ id ].format = response.data;
                    })
                    .catch(function(){
                        console.log('FAILURE VIDEO UPLOAD!!');
                    });

            },
            chainVideo(index) {
                this.bot.chain[ index ].videos.push( JSON.parse(JSON.stringify(this.template.video)) );
            },
            removeDocument(index, id) {
                this.bot.chain[ index ].documents.splice(id,1);
            },
            documentFile(index,id) {
                document.getElementById('document'+index+'-'+id).click();
            },
            documentDescription(index,id) {
                this.bot.chain[ index ].documents[ id ].description = true;
            },
            documentUpload(index,id) {
                this.bot.chain[ index ].documents[ id ].status = true;
                this.bot.chain[ index ].documents[ id ].file = document.getElementById('document'+index+'-'+id).files[0];
                let data = this.data('document', this.bot.chain[ index ].documents[ id ].file );
                let self = this;
                axios.post( '/document-upload',
                    data,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        onUploadProgress: function(progressEvent) {
                            self.bot.chain[ index ].documents[ id ].percent = parseInt(( progressEvent.loaded / progressEvent.total) * 100);
                        }
                    }
                )
                    .then(function(response) {
                        console.log(response.data);
                        self.bot.chain[ index ].documents[ id ].ready = true;
                        self.bot.chain[ index ].documents[ id ].format = response.data;
                    })
                    .catch(function(){
                        console.log('FAILURE DOCUMENT UPLOAD!!');
                    });
            },
            chainDocument(index) {
                this.bot.chain[ index ].documents.push( JSON.parse(JSON.stringify(this.template.document)) );
            },
            removeSound(index, id) {
                this.bot.chain[ index ].sounds.splice(id,1);
            },
            soundFile(index,id) {
                document.getElementById('sound'+index+'-'+id).click();
            },
            soundDescription(index,id) {
                this.bot.chain[ index ].sounds[ id ].description = true;
            },
            soundUpload(index,id) {
                this.bot.chain[ index ].sounds[ id ].status = true;
                this.bot.chain[ index ].sounds[ id ].file = document.getElementById('sound'+index+'-'+id).files[0];
                let data = this.data('sound', this.bot.chain[ index ].sounds[ id ].file );
                let self = this;
                axios.post( '/sound-upload',
                    data,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        onUploadProgress: function(progressEvent) {
                            self.bot.chain[ index ].sounds[ id ].percent = parseInt(( progressEvent.loaded / progressEvent.total) * 100);
                        }
                    }
                )
                    .then(function(response) {
                        console.log(response.data);
                        self.bot.chain[ index ].sounds[ id ].ready = true;
                        self.bot.chain[ index ].sounds[ id ].format = response.data;
                    })
                    .catch(function(){
                        console.log('FAILURE SOUND UPLOAD!!');
                    });
            },
            chainSound(index) {
                this.bot.chain[ index ].sounds.push( JSON.parse(JSON.stringify(this.template.sound)) );
            },
            removeAudio(index, id) {
                this.bot.chain[ index ].audios.splice(id,1);
            },
            audioFile(index,id) {
                document.getElementById('audio'+index+'-'+id).click();
            },
            audioDescription(index,id) {
                this.bot.chain[ index ].audios[ id ].description = true;
            },
            audioUpload(index,id) {
                this.bot.chain[ index ].audios[ id ].status = true;
                this.bot.chain[ index ].audios[ id ].file = document.getElementById('audio'+index+'-'+id).files[0];
                let data = this.data('audio', this.bot.chain[ index ].audios[ id ].file );
                let self = this;
                axios.post( '/audio-upload',
                    data,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        onUploadProgress: function(progressEvent) {
                            self.bot.chain[ index ].audios[ id ].percent = parseInt(( progressEvent.loaded / progressEvent.total) * 100);
                        }
                    }
                )
                    .then(function(response) {
                        console.log(response.data);
                        self.bot.chain[ index ].audios[ id ].ready = true;
                        self.bot.chain[ index ].audios[ id ].format = response.data;
                    })
                    .catch(function(){
                        console.log('FAILURE AUDIO UPLOAD!!');
                    });
            },
            chainAudio(index) {
                this.bot.chain[ index ].audios.push( JSON.parse(JSON.stringify(this.template.audio)) );
            },

            data(name,file) {
                let formData = new FormData();
                formData.append(name,file);
                return formData;
            },
            saveEditBot() {
                if (this.botName === '') {
                    return this.$refs.bot.focus();
                }

                axios.post('/ajax/save/bot', {
                    id: this.editId,
                    chain: this.bot.chain,
                    name: this.botName,
                }).then(function (response) {

                    console.log(response.data);
                    window.location.href = '/analyze';
                }).catch(function (error) {

                });
            },
            createBot() {
                if (this.botName.trim() === '') {
                    return this.$refs.bot.focus();
                }

                axios.post('/home', {
                    chain: this.bot.chain,
                    name: this.botName,
                }).then(function (response) {

                    console.log(response.data);
                    window.location.href = '/analyze';
                }).catch(function (error) {

                });
            },
            deleteChain(index) {
                let chain = this.bot.chain[ index ];
                let block = -1;
                let self = this;
                let connect = [];
                let connectChain = -1;
                for (let i in chain.connected) {
                    connect = i.split('-');
                    this.bot.chain[ connect[0] ].answers[ connect[1] ].connect = {
                        status: false,
                        active: false,
                        block: -1,
                        l1: 0,
                        l2: 0,
                        endWidth: 0,
                        endHeight: 0,
                    };
                }
                chain.answers.forEach(function callback(currentValue, id, array) {
                    if (currentValue.connect.block !== -1) {
                        block = self.bot.chain[ currentValue.connect.block ];
                        delete block.connected[index+'-'+id];
                    }
                });
                this.bot.chain.splice(index, 1);
            },
            addAnswer(index) {
                this.bot.chain[ index ].answers.push( JSON.parse(JSON.stringify(this.template.answer)) );
            },
            deleteAnswer(index, id) {
                this.bot.chain[ index ].answers.splice(id, 1);
            },
            options(id) {
                this.options_id = id;
                this.right_options = true;
            },
            addChain(id) {
                if (id === 0) {
                    this.bot.chain.push( JSON.parse(JSON.stringify(this.template.message)) );
                } else if (id === 1) {
                    this.bot.chain.push( JSON.parse(JSON.stringify(this.template.messageChain)) );
                }
                this.modal = false;
            },
            moveStop() {
                this.drag.status = false;
                let self = this;
                this.bot.chain.forEach(function callback(val, id, arr) {
                    val.answers.forEach(function callback(currentValue, index, array) {
                        if (val.answers[ index ].connect.status) {
                            val.answers[ index ].connect.status = false;
                            if (val.answers[ index ].connect.block === -1) {
                                val.answers[ index ].connect = {
                                    status: false,
                                    active: false,
                                    block: -1,
                                    l1: 0,
                                    l2: 0,
                                    endWidth: 0,
                                    endHeight: 0,
                                };
                            }
                        }
                    });
                });
                this.lineChain();
            },
            chainMessage(mid, index, X, Y) {
                let block = -1;
                let self = this;
                let status = true;
                this.bot.chain.forEach(function (val, id, arr) {
                    if (mid !== id && status) {
                        if (
                            (X > (val.X+70) && X < (val.X + 410)) &&
                            ( Y > (val.Y+70) && Y < (val.Y + 70 + self.$refs['chain_'+id][0].clientHeight))
                        ) {
                            block = id;
                            status = false;
                        }
                    }
                });
                return block;
            },
            detail(id) {
                let rect = this.$refs['chain_'+id][0].getBoundingClientRect();
                let data = {
                    left: rect.left + window.scrollX,
                    top: rect.top + window.scrollY,
                };
                data.right = data.left + rect.width;
                data.bottom = data.top + rect.height;
                return data;
            },
            detailBlocks(connect, rect) {
                let pos = {
                    top: false,
                    bottom: false,
                    left: false,
                    right: false,
                };
                let H = (rect.top - connect.coor.top), W = (rect.left - connect.coor.left), position = {
                    Y: 0,
                    X: 0,
                }, distance = 20;
                // && (connect.coor.left + connect.coor.endWidth) < rect.left
                if ((connect.coor.left < rect.left) || (connect.coor.left < rect.right)) {
                    pos.left = true;
                } else if (connect.coor.left > rect.right) {
                    W = 0 - W;
                    pos.right = true;
                }

                if ((connect.coor.top < rect.top) || (connect.coor.top < rect.bottom)) {
                    pos.top = true;
                } else if (connect.coor.top > rect.bottom) {
                    H = 0 - H;
                    pos.bottom = true;
                }

                if (H > W) {
                    pos.left = false;
                    pos.right = false;
                    position.X = rect.left + ((rect.right - rect.left) / 2);
                    if (pos.top) {
                        position.Y = rect.top - distance;
                    } else if (pos.bottom) {
                        position.Y = rect.bottom + distance;
                    }
                } else if (H < W) {
                    pos.top = false;
                    pos.bottom = false;
                    position.Y = rect.top + ((rect.bottom - rect.top) / 2);
                    if (pos.left) {
                        position.X = rect.left - distance/2;
                    } else if (pos.right) {
                        position.X = rect.right + distance/2;
                    }
                }
                return position;
            },
            setCoor(currentValue, coor) {
                currentValue.connect.width = coor.width;
                currentValue.connect.height = coor.height;
                currentValue.connect.endWidth = coor.endWidth;
                currentValue.connect.endHeight = coor.endHeight;
                currentValue.connect.l1 = coor.l1;
                currentValue.connect.l2 = coor.l2;
            },
            coorMove(id, index, X, Y) {

                let info = this.bot.chain[ id ].answers[ index ].connect.coor;

                info.block = this.chainMessage(id, index, X, Y);
                info.width = X - info.left;
                info.height = Y - info.top;

                if (info.left > X) {
                    info.width = info.left - X;
                }
                if (info.top > Y) {
                    info.height = info.top - Y;
                }
                info.endWidth = info.width+30;
                info.endHeight = info.height+30;
                if (info.endWidth<50) info.endWidth = 80;
                if (info.endHeight<50) info.endHeight = 80;

                info.l1 = info.endWidth + info.width;
                info.l2 = info.endHeight + info.height;

                if (info.left > X) {
                    info.l1 = info.endWidth - info.width;
                }
                if (info.top > Y) {
                    info.l2 = info.endHeight - info.height;
                }
                return info;
            },
            coor(ev) {
                let rect = ev.target.getBoundingClientRect();
                return {
                    left: rect.left,
                    top: rect.top,
                };
            },
            line(event,index, id) {
                if (!this.bot.chain[ index ].answers[ id ].connect.status) {

                    if (this.bot.chain[ index ].answers[ id ].connect.block !== -1) {
                        delete this.bot.chain[ this.bot.chain[ index ].answers[ id ].connect.block ].connected[index+'-'+id];
                        this.bot.chain[ index ].answers[ id ].connect.block = -1;
                    }
                    this.bot.chain[ index ].answers[ id ].connect.status = true;
                    this.bot.chain[ index ].answers[ id ].connect.active = true;
                    this.bot.chain[ index ].answers[ id ].connect.coor = this.coor(event);
                }
            },
            move(event) {

                let Y = event.clientY;
                let X = event.clientX;
                let self = this;

                if (this.drag.status) {
                    let pointY = event.offsetY - this.drag.Y;
                    let pointX = event.offsetX - this.drag.X;
                    let item = this.bot.chain[ this.drag.index ];
                    let newY = item.Y+pointY;
                    let newX = item.X+pointX;
                    item.Y = newY<0?0:newY;
                    item.X = newX<0?0:newX;
                    /*item.answers.forEach(function callback(currentValue, index, array) {
                        if (currentValue.connect.status) {
                            let coor = self.coorMove( self.drag.index , index, X, Y);
                            if (coor.block !== -1) {
                                self.bot.chain[coor.block].connected[ self.drag.index+'-'+index] = item.type;
                            }
                            currentValue.connect.block = coor.block;
                            currentValue.connect.width = coor.width;
                            currentValue.connect.height = coor.height;
                            currentValue.connect.endWidth = coor.endWidth;
                            currentValue.connect.endHeight = coor.endHeight;
                            currentValue.connect.l1 = coor.l1;
                            currentValue.connect.l2 = coor.l2;
                        }
                    });*/
                } else {
                    this.bot.chain.forEach(function callback(val, id, arr) {
                        val.answers.forEach(function callback(currentValue, index, array) {
                            if (currentValue.connect.status) {
                                let coor = self.coorMove(id, index, X, Y);
                                if (coor.block !== -1) {
                                    arr[coor.block].connected[id+'-'+index] = val.type;
                                }
                                currentValue.connect.block = coor.block;
                                currentValue.connect.width = coor.width;
                                currentValue.connect.height = coor.height;
                                currentValue.connect.endWidth = coor.endWidth;
                                currentValue.connect.endHeight = coor.endHeight;
                                currentValue.connect.l1 = coor.l1;
                                currentValue.connect.l2 = coor.l2;
                            }
                        });
                    });
                }

                this.lineChain();
                if (this.editId == 0) {
                    localStorage.chain = JSON.stringify(this.bot.chain);
                }
            },
            lineChain() {
                let self = this;
                let rect;
                let position;
                let coor;



                this.bot.chain.forEach(function callback(val, id, arr) {
                    val.answers.forEach(function callback(currentValue, index, array) {
                        if (currentValue.connect.block !== -1) {
                            rect = self.detail(currentValue.connect.block);
                            position = self.detailBlocks(currentValue.connect, rect);
                            coor = self.coorMove(id, index, position.X, position.Y);
                            self.setCoor(currentValue, coor);
                        }
                    });
                    for (let i in val.connected) {
                        let arr = i.split('-');
                        let answer = self.bot.chain[ arr[0] ].answers[ arr[1] ];
                        rect = self.detail(answer.connect.block);
                        position = self.detailBlocks(answer.connect, rect);
                        coor = self.coorMove(arr[0], arr[1], position.X, position.Y);
                        self.setCoor(answer, coor);
                    }

                });


            },
            down(event, index) {
                if (!this.drag.status) {
                    this.drag.status = true;
                    this.drag.index = index;
                    this.drag.Y = event.offsetY;
                    this.drag.X = event.offsetX;
                }
            },
            /*

                    <div class="content-scheme-item-disabled content-scheme-item-condition" onselectstart="return false;">
                        <div class="content-scheme-item-btn-list">
                            <div class="content-scheme-item-btn-copy">
                                <i class="fas fa-copy"></i>
                            </div>
                            <div class="content-scheme-item-btn-delete">
                                <i class="fas fa-trash-alt"></i>
                            </div>
                        </div>
                        <div class="content-scheme-item-body">
                            <div class="content-scheme-item-body-head"><i class="fas fa-greater-than-equal"></i> Условие</div>
                            <div class="content-scheme-item-body-content">
                                <button class="btn btn-success w-100 text-left">
                                    <span>Да</span>
                                    <div class="content-scheme-item-node">
                                        <div class="content-scheme-item-node-icon"></div>
                                    </div>
                                </button>
                                <button class="btn btn-danger w-100 text-left">
                                    <span>Нет</span>
                                    <div class="content-scheme-item-node">
                                        <div class="content-scheme-item-node-icon"></div>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>

             */
        }
    }
</script>

<style scoped>
    .remove-btn {
        top: -15px;
        right: -15px;
    }
    .invisible {
        visibility: hidden;
        position: absolute;
    }
    .grid-button {
        display: grid;
        grid-template-columns: auto 36px;
        grid-gap: 15px;
    }
</style>
