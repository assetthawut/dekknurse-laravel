<template>
    <div class="container">
        <div>
            <!-- <b-form v-if="true"> -->
            <!-- Image. -->
            <b-row class="text-center">
                <b-col cols="3"> Logo</b-col>
                <b-col cols="6">
                    <span @click="showPopularPost()">Top</span> |
                    <span @click="showLatestPost()"> Lastest</span></b-col
                >
                <b-col cols="3"> Search Panel</b-col>
            </b-row>
            <b-row class="text-center">
                <b-col cols="3">
                    <!-- Header -->
                    <div
                        class="text-right"
                        @click="$bvModal.show('bv-modal-add-tag')"
                    >
                        <b-icon icon="plus-circle"></b-icon>
                    </div>
                    <div>
                        <h5>Popular Tag</h5>
                    </div>
                    <b-list-group>
                        <!-- <b-list-group-item class="d-flex align-items-center">
                            <b-avatar class="mr-3"></b-avatar>
                            <span class="mr-auto">J. Circlehead</span>
                        </b-list-group-item> -->
                        <!--  v-for="item in items" -->
                        <b-list-group-item
                            class="d-flex align-items-center"
                            v-for="account in popularAccounts"
                        >
                            <b-avatar
                                class="mr-3"
                                :src="account.profile_url"
                            ></b-avatar>
                            <span class="mr-auto">{{ account.name }} </span>
                            <small>{{ account.count }} Posts</small>
                        </b-list-group-item>
                    </b-list-group>
                </b-col>
                <b-col cols="6">
                    <!-- Menu -->
                    <b-row
                        class="text-center m-3 p-3"
                        style="background-color: #dee2e6"
                    >
                        <b-col cols="12"
                            ><div>
                                <b-button
                                    variant=""
                                    @click="$bvModal.show('bv-modal-example')"
                                    >โพสต์</b-button
                                >
                                <b-button variant="outline-primary"
                                    >สงสัย</b-button
                                >
                            </div></b-col
                        >
                    </b-row>
                    <!-- Posts popularPosts -->
                    <b-row
                        class="m-3 p-3"
                        style="background-color: #f8f9fa"
                        v-for="post in popularPosts"
                        @click="gotoPost(post.id)"
                    >
                        <b-col cols="12 text-left">
                            <div class="text-right">
                                <span>1 ชม.</span>
                                <b-icon icon="share-fill"></b-icon>
                            </div>
                            <!-- post Header -->
                            <h6>{{ post.detail }}</h6>
                            <!-- post account -->
                            <div>
                                <b-badge v-for="postAccount in post.accounts">
                                    {{ postAccount.name }}
                                </b-badge>
                            </div>
                            <!-- post url -->
                            <div>
                                <a :href="post.url">{{ post.url }}</a>
                            </div>
                            <!-- post hashtag -->
                            <div>
                                <span>{{ post.hashtags }}</span>
                            </div>
                            <!-- post icon -->
                            <div>
                                <b-row
                                    class="m-1 p-1"
                                    style="background-color: #b8daff"
                                >
                                    <b-col cols="4 text-left">
                                        <b-icon icon="chat"></b-icon>
                                        <span>
                                            {{ post.comments.length }}</span
                                        ></b-col
                                    >
                                    <b-col cols="4 text-left">
                                        <b-icon icon="arrow-clockwise"></b-icon
                                        ><span>
                                            {{ post.retweets }}</span
                                        ></b-col
                                    >
                                    <b-col cols="4 text-left">
                                        <b-icon icon="suit-heart"></b-icon
                                        ><span>
                                            {{ post.favorites }}</span
                                        ></b-col
                                    >
                                </b-row>
                            </div>
                            <div>
                                <b-input-group class="mt-3">
                                    <template #append>
                                        <b-input-group-text
                                            ><strong class="text-danger">
                                                <b-icon
                                                    icon="file-image"
                                                ></b-icon>
                                                <b-icon icon="hash"></b-icon>
                                                <b-icon
                                                    icon="link45deg"
                                                ></b-icon></strong
                                        ></b-input-group-text>
                                    </template>
                                    <b-form-input
                                        placeholder="เขียนความคิดเห็น..."
                                    ></b-form-input>
                                </b-input-group>
                            </div>
                        </b-col>
                    </b-row>
                </b-col>
                <b-col cols="3">
                    <!-- Header -->
                    <div>
                        <h5>Trending</h5>
                    </div>
                    <!-- Body -->
                    <b-list-group>
                        <b-list-group-item
                            class="d-flex align-items-center"
                            v-for="hashtag in popularTags"
                            >{{ hashtag.word }} ({{
                                hashtag.total
                            }})</b-list-group-item
                        >
                    </b-list-group>
                </b-col>
            </b-row>
        </div>

        <!-- Popup -->
        <div>
            <b-modal id="bv-modal-example" hide-header hide-footer>
                <div class="text-right mb-1">
                    <b-button @click="$bvModal.hide('bv-modal-example')"
                        >X</b-button
                    >
                </div>
                <!-- detail -->
                <div class="d-block text-center">
                    <b-form-textarea
                        id="textarea"
                        v-model="detail"
                        placeholder="คุณสงสัยอะไร..."
                        rows="3"
                        max-rows="6"
                    ></b-form-textarea>
                </div>
                <!-- account -->

                <v-select
                    :options="accounts"
                    v-model="selected"
                    :reduce="(accounts) => accounts.id"
                    multiple
                    label="name"
                    placeholder="tags"
                ></v-select>
                {{ selected }}
                <!-- link -->
                <div class="d-block text-center mt-2">
                    <b-form-input
                        v-model="url"
                        placeholder="Link"
                    ></b-form-input>
                </div>
                <!-- Hash tag -->
                <div class="d-block text-center mt-2">
                    <b-form-input
                        v-model="hashtag"
                        placeholder="hashtag"
                    ></b-form-input>
                </div>
                <div class="text-right mt-2">
                    <b-button @click="submitPost()">Post</b-button>
                </div>
                <!-- <b-button
                    class="mt-3"
                    block
                    @click="$bvModal.hide('bv-modal-example')"
                    >Close Me</b-button
                > -->
            </b-modal>
        </div>
        <!-- add tag form -->
        <div>
            <b-modal id="bv-modal-add-tag" hide-header hide-footer>
                <div class="text-right mb-1">
                    <b-button @click="$bvModal.hide('bv-modal-add-tag')"
                        >X</b-button
                    >
                </div>
                <div class="text-center">
                    <h5>Add Tag</h5>
                </div>
                <div>
                    <b-input-group class="mt-3">
                        <template #append>
                            <b-input-group-text v-if="!searchTag">
                                <b-icon icon="search"></b-icon
                            ></b-input-group-text>
                            <b-input-group-text v-if="searchTag">
                                <b-icon
                                    icon="plus"
                                    @click="createTag()"
                                ></b-icon
                            ></b-input-group-text>
                        </template>
                        <b-form-input
                            id="input-live"
                            v-model="searchTag"
                            aria-describedby="input-live-help input-live-feedback"
                            placeholder="Enter your name"
                            trim
                            v-on:input="userSearchTag"
                        ></b-form-input>
                    </b-input-group>
                </div>
                <div>
                    <b-list-group>
                        <!-- <b-list-group-item class="d-flex align-items-center">
                            <b-avatar class="mr-3"></b-avatar>
                            <span class="mr-auto">J. Circlehead</span>
                        </b-list-group-item> -->
                        <!--  v-for="item in items" -->
                        <b-list-group-item
                            class="d-flex align-items-center my-2"
                            v-if="searchTag"
                        >
                            <b-avatar class="mr-3">
                                <input
                                    @change="handleImage"
                                    class="custom-input"
                                    type="file"
                                    accept="image/*"
                            /></b-avatar>
                            <span class="mr-auto">{{ searchTag }} </span>
                            <small>0 Posts</small>
                        </b-list-group-item>

                        <b-list-group-item
                            class="d-flex align-items-center"
                            v-for="account in filteredTags"
                        >
                            <b-avatar class="mr-3">
                                <input
                                    @change="
                                        handleUpdateImage($event, account.id)
                                    "
                                    class="custom-input"
                                    type="file"
                                    accept="image/*"
                                />
                            </b-avatar>
                            <span class="mr-auto">{{ account.name }} </span>
                            <small>{{ account.count }} Posts</small>
                        </b-list-group-item>
                    </b-list-group>
                </div>
            </b-modal>
        </div>
        <!-- Popup Comfirm update imate -->
        <div>
            <b-modal id="bv-modal-confirm-update-image" hide-header hide-footer>
                <div class="text-right mb-1">
                    <b-button
                        @click="$bvModal.hide('bv-modal-confirm-update-image')"
                        >X</b-button
                    >
                </div>
                <div class="text-center">
                    <h5>ยืนยันการ upload ภาพ</h5>
                </div>
                <div class="text-right mt-2">
                    <b-button @click="updateTag()">Submit</b-button>
                </div>
                <!-- <b-button
                    class="mt-3"
                    block
                    @click="$bvModal.hide('bv-modal-example')"
                    >Close Me</b-button
                > -->
            </b-modal>
        </div>
    </div>
</template>

<script>
import $ from "jquery";
import "@fullcalendar/core/vdom"; // solves problem with Vite
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
export default {
    components: {
        FullCalendar, // make the <FullCalendar> tag available
    },
    data() {
        return {
            detail: "",
            url: "",
            hashtag: "",
            selected: "",
            options: [
                { value: "1", text: "คนที่ 1", disabled: true },
                { value: "2", text: "คนที่ 2", disabled: true },
                { value: "3", text: "คนที่ 3", disabled: true },
                { value: "4", text: "คนที่ 4", disabled: true },
                { value: "5", text: "คนที่ 5", disabled: true },
            ],
            mainProps: {
                center: true,
                fluidGrow: true,
                blank: true,
                blankColor: "#bbb",
                class: "w-50",
            },
            show: true,
            file1: null,
            file2: null,
            profileUrl: "",
            profileImgBase64: [],
            collectionUrl: "",
            collectionName: "",
            twitterUrl: "",
            discordUrl: "",
            parasUrl: "",
            collectionBase64: "",
            isLogin: false,
            userInfo: {},
            token: "",
            overlay: false,
            isExclusiveUser: false,
            onSaving: false,
            counter: 0,
            fileSizeExceed: false,
            cryptoUrl: "",
            userPlatformId: "",
            facebookUrl: "",
            utility: "",
            popularAccounts: [],
            popularTags: [],
            accounts: [],
            popularPosts: [],
            lastestPosts: [],
            isShowPopularPost: true,
            searchTag: "",
            filteredTags: [],
            timer: null,
            image: "",
            confirmUpdateImage: false,
            confirmUpdateImageAccountId: null,
        };
    },
    async mounted() {
        await this.getAllAccount();
        await this.getPopularAccount();
        await this.getPopularaHashtag();
        await this.getPopularaPost();
    },
    methods: {
        toast(toaster, append = false) {
            this.counter++;
            this.$bvToast.toast(`Toast ${this.counter} body content`, {
                title: `Toaster ${toaster}`,
                toaster: toaster,
                solid: true,
                appendToast: append,
            });
        },
        // onClickEvent: function (arg) {
        //   console.log("on click event", arg);
        //   console.log(this.kkk);
        //   this.toggleModal();
        // },
        // handleDateClick2: function (arg) {
        //   console.log(arg);
        //   this.toggleShow();
        // },
        // handleDateClick: function (arg) {
        //   console.log(arg);
        // },
        // toggleWeekends: function () {
        //   this.calendarOptions.weekends = !this.calendarOptions.weekends; // toggle the boolean!
        // },
        // showModal() {
        //   this.$refs["my-modal"].show();
        // },
        // hideModal() {
        //   this.$refs["my-modal"].hide();
        // },
        // toggleModal() {
        //   // We pass the ID of the button that we want to return focus to
        //   // when the modal has hidden
        //   this.$refs["my-modal"].toggle("#toggle-btn");
        // },
        // handleEventClick() {
        //   console.log("---->");
        //   // console.log(this.kkk)
        // },
        // toggleShow() {
        //   console.log("showww", this.show);
        //   this.show = !this.show;
        // },
        onFileChange(e) {
            const file = e.target.files[0];
            this.collectionUrl = URL.createObjectURL(file);
            // 2000000 == 2 MB
            if (file.size > 2000000) {
                this.fileSizeExceed = true;
                this.profileImgBase64 = [];
                this.collectionUrl = "";
                let $this = this;
                setTimeout(function () {
                    $this.fileSizeExceed = false;
                }, 3000);
            } else {
                this.fileSizeExceed = false;
            }
            // this.profileUrl = URL.createObjectURL(this.profileImgBase64);
            // console.log("--->",this.profileUrl)
        },

        saveProfile: function () {
            let notificationSuccessToast = (vm, append = false) => {
                vm.$bvToast.toast(`Update user profile`, {
                    title: "Update user profile successfully",
                    autoHideDelay: 3000,
                    appendToast: append,
                    variant: "success",
                });
            };

            let notificationErrorToast = (vm, append = false) => {
                vm.$bvToast.toast(`Update user profile`, {
                    title: "Someting went wrong",
                    autoHideDelay: 3000,
                    appendToast: append,
                    variant: "danger",
                });
            };
            this.onSaving = true;
            const config = {
                headers: {
                    "Content-type": "application/json",
                    Authorization: `Bearer ${this.token}`,
                },
            };
            this.overlay = true;
            let body = {
                paras_url: this.parasUrl,
                discord_url: this.discordUrl,
                twitter_url: this.twitterUrl,
                crypto_url: this.cryptoUrl,
                facebook_url: this.facebookUrl,
                collection_name: this.collectionName,
                collection_base64: this.profileImgBase64,
                platform_id: this.selected,
                utility: this.utility,
            };

            let userId = this.userInfo.id;
            var datax = new FormData();
            Object.entries(body).forEach(([key, value]) => {
                datax.append(key, value);
            });
            let $this = this;
            axios
                .post(`/api/profile/${userId}?_method=PUT`, datax, config)
                .then(function (response) {
                    notificationSuccessToast($this, true);
                    let result = response.data;
                    $this.overlay = false;
                    $this.onSaving = false;
                })
                .catch(function (error) {
                    notificationErrorToast($this, true);
                    $this.overlay = false;
                    $this.dialog = true;
                    $this.onSaving = false;
                    console.log(error);
                });
        },
        getUserInfo() {
            let userId = this.userInfo.id;
            let $this = this;
            const config = {
                headers: {
                    "Content-type": "application/json",
                    Authorization: `Bearer ${this.token}`,
                },
            };

            axios
                .get(`/api/user/${userId}`, config)
                .then(function (response) {
                    let result = response.data;
                    $this.overlay = false;
                    $this.userInfo = result.data;
                    $this.parasUrl = $this.userInfo.paras_url;
                    $this.selected = $this.userInfo.platform_id;
                    $this.userPlatformId = $this.userInfo.platform_id;
                    $this.discordUrl =
                        $this.userInfo.discord_url &&
                        $this.userInfo.discord_url != "null"
                            ? $this.userInfo.discord_url
                            : "";
                    $this.twitterUrl =
                        $this.userInfo.twitter_url &&
                        $this.userInfo.twitter_url != "null"
                            ? $this.userInfo.twitter_url
                            : "";
                    $this.cryptoUrl =
                        $this.userInfo.crypto_url &&
                        $this.userInfo.crypto_url != "null"
                            ? $this.userInfo.crypto_url
                            : "";
                    $this.collectionName = $this.userInfo.collection_name;
                    $this.collectionUrl = $this.userInfo.collection_url;
                    $this.facebookUrl =
                        $this.userInfo.facebook_url &&
                        $this.userInfo.facebook_url != "null"
                            ? $this.userInfo.facebook_url
                            : "";
                    $this.utility =
                        $this.userInfo.utility &&
                        $this.userInfo.utility != "null"
                            ? $this.userInfo.utility
                            : "";
                })
                .catch(function (error) {
                    $this.overlay = false;
                    $this.dialog = true;
                    console.log(error);
                });
        },
        uploadImages(event) {
            let image_id = Math.floor(
                Math.random() * (1000000 - 1000 + 1) + 1000
            );
            let name = "image_" + image_id;
            let imageData = null;
            let context = null;
            let maxWidth = 1024;
            let maxHeigt = 768;
            let width = maxWidth;
            let height = maxHeigt;
            let vm = this;
            let files = event.target.files;
            vm.imageIndex = 0;

            let formData = new FormData();
            for (let i = 0; i < files.length; i++) {
                let reader = new FileReader();
                let file = files[i];

                if (!file.type.match("image")) continue;
                if (file.type == "image/gif") {
                    this.collectionUrl = URL.createObjectURL(file);
                    this.profileImgBase64 = file;
                } else {
                    var img = document.createElement("img");
                    var canvas = $("<canvas/>").get(0);
                    reader.onload = function (e) {
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                    let $this = this;
                    img.onload = function () {
                        // Draw
                        context = canvas.getContext("2d");
                        context.drawImage(img, 0, 0);
                        if (img.width > maxWidth || img.height > maxHeigt) {
                            width = maxWidth;
                            height = maxHeigt;

                            if (img.width > maxWidth) {
                                width = maxWidth;
                                var ration = maxWidth / img.width;
                                height = Math.round(img.height * ration);
                            }

                            if (img.height > maxHeigt) {
                                height = maxHeigt;
                                var ration = maxHeigt / img.height;
                                width = Math.round(img.width * ration);
                            }
                        } else {
                            width = img.width;
                            height = img.height;
                        }
                        canvas.width = width;
                        canvas.height = height;

                        context.drawImage(img, 0, 0, width, height);
                        imageData = canvas.toDataURL("image/jpeg");
                        imageData.replace("data:image/jpeg;base64,", "");

                        let blobToFile = vm.dataURItoBlob(imageData);
                        const cfile = new File([blobToFile], name + ".jpg", {
                            type: "image/jpeg",
                            lastModified: Date.now(),
                        });
                        $this.profileImgBase64 = cfile;
                        // console.log("this.profileImgBase64 --->", $this.profileImgBase64);
                        const file = event.target.files[0];
                        $this.collectionUrl = URL.createObjectURL(cfile);
                        // console.log("this.collectionUrl", $this.collectionUrl);
                    };
                }
            }
        },

        dataURItoBlob(dataURI) {
            // convert base64 to raw binary data held in a string
            var byteString = atob(dataURI.split(",")[1]);
            // separate out the mime component
            var mimeString = dataURI.split(",")[0].split(":")[1].split(";")[0];
            // write the bytes of the string to an ArrayBuffer
            var arrayBuffer = new ArrayBuffer(byteString.length);
            var _ia = new Uint8Array(arrayBuffer);
            for (var i = 0; i < byteString.length; i++) {
                _ia[i] = byteString.charCodeAt(i);
            }
            var dataView = new DataView(arrayBuffer);
            var blob = new Blob([dataView], { type: mimeString });
            return blob;
        },
        async getPopularAccount() {
            let $this = this;
            const config = {
                headers: {
                    "Content-type": "application/json",
                },
            };

            await axios
                .get(`/api/account/tagged?orderby=desc`, config)
                .then(function (response) {
                    let result = response.data;
                    console.log("result", result);
                    $this.popularAccounts = result.data;
                })
                .catch(function (error) {
                    // $this.overlay = false;
                    // $this.dialog = true;
                    console.log(error);
                });
        },
        async getPopularaHashtag() {
            let $this = this;
            const config = {
                headers: {
                    "Content-type": "application/json",
                },
            };

            await axios
                .get(`/api/hashtag/tagged?orderby=desc`, config)
                .then(function (response) {
                    let result = response.data;
                    console.log("result", result);
                    $this.popularTags = result.data;
                })
                .catch(function (error) {
                    // $this.overlay = false;
                    // $this.dialog = true;
                    console.log(error);
                });
        },
        async getAllAccount() {
            let $this = this;
            const config = {
                headers: {
                    "Content-type": "application/json",
                },
            };

            await axios
                .get(`/api/account/list`, config)
                .then(function (response) {
                    let result = response.data;
                    console.log("result", result);
                    $this.accounts = result.data;
                })
                .catch(function (error) {
                    // $this.overlay = false;
                    // $this.dialog = true;
                    console.log(error);
                });
        },
        async getPopularaPost() {
            let $this = this;
            const config = {
                headers: {
                    "Content-type": "application/json",
                },
            };

            await axios
                .get(`/api/post/list`, config)
                .then(function (response) {
                    let result = response.data;
                    console.log("result", result);
                    $this.popularPosts = result.data;
                })
                .catch(function (error) {
                    // $this.overlay = false;
                    // $this.dialog = true;
                    console.log(error);
                });
        },
        async getLatestPost() {
            let $this = this;
            const config = {
                headers: {
                    "Content-type": "application/json",
                },
            };

            await axios
                .get(`/api/post/latest`, config)
                .then(function (response) {
                    let result = response.data;
                    console.log("result", result);
                    $this.popularPosts = result.data;
                })
                .catch(function (error) {
                    // $this.overlay = false;
                    // $this.dialog = true;
                    console.log(error);
                });
        },
        submitPost() {
            console.log("submit post");
            this.$bvModal.hide("bv-modal-example");
            const config = {
                headers: {
                    "Content-type": "application/json",
                },
            };
            // this.overlay = true;
            let body = {
                detail: this.detail,
                hashtags: this.hashtag,
                url: this.url,
                account_id: this.selected,
            };
            console.log("body", body);
            var datax = new FormData();
            Object.entries(body).forEach(([key, value]) => {
                datax.append(key, value);
            });
            console.log("datax", datax);
            let $this = this;
            axios
                .post(`/api/post`, body, config)
                .then(function (response) {
                    console.log("response", response);
                    $this.getAllAccount();
                    $this.getPopularAccount();
                    $this.getPopularaHashtag();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        async showPopularPost() {
            console.log("showPopularPost");
            this.isShowPopularPost = true;
            this.popularPosts = [];
            await this.getPopularaPost();
        },
        async showLatestPost() {
            console.log("showLatestPost");
            this.isShowPopularPost = false;
            this.popularPosts = [];
            await this.getLatestPost();
        },
        gotoPost(id) {
            console.log("Post", id);
            window.location.href = `/post-tag/${id}`;
        },
        displayAddTagForm() {
            console.log("...");
        },
        userSearchTag() {
            clearTimeout(this.timer);
            this.timer = setTimeout(() => {
                this.filteredTags = this.accounts.filter((i) =>
                    i.name.includes(this.searchTag)
                );
                console.log("test", this.filteredTags);
                console.log(" this.accounts", this.accounts);
            }, 500);
        },
        handleImage(e) {
            const selectedImage = e.target.files[0]; // get first file
            this.createBase64Image(selectedImage);
        },
        handleUpdateImage(e, id) {
            const selectedImage = e.target.files[0]; // get first file
            this.createBase64Image(selectedImage);
            console.log(id);
            console.log(this.image);
            this.confirmUpdateImage = true;
            this.confirmUpdateImageAccountId = id;
            this.$bvModal.show("bv-modal-confirm-update-image");
        },
        createBase64Image(fileObject) {
            const reader = new FileReader();

            reader.onload = (e) => {
                this.image = e.target.result;
                this.uploadImage();
            };
            reader.readAsDataURL(fileObject);
        },
        uploadImage() {
            const { image } = this;
            console.log(image);
            // axios
            //     .post("http://127.0.0.1:8081/upload", { image })
            //     .then((response) => {
            //         this.remoteUrl = response.data.url;
            //     })
            //     .catch((err) => {
            //         return new Error(err.message);
            //     });
        },
        createTag() {
            console.log("searchTag", this.searchTag);
            console.log("image", this.image);
            let body = {
                name: this.searchTag,
                profile_image: this.image,
            };
            console.log("body", body);
            const config = {
                headers: {
                    "Content-type": "application/json",
                    Authorization: `Bearer ${this.token}`,
                },
            };
            let $this = this;
            axios
                .post(`/api/account`, body, config)
                .then(function (response) {
                    console.log("response", response);
                    $this.$bvModal.hide("bv-modal-add-tag");
                    $this.getAllAccount();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        updateTag() {
            console.log("update..");
            let body = {
                profile_image: this.image,
            };
            console.log("body", body);
            const config = {
                headers: {
                    "Content-type": "application/json",
                    Authorization: `Bearer ${this.token}`,
                },
            };
            let $this = this;
            axios
                .patch(
                    `/api/account/${this.confirmUpdateImageAccountId}/update-profile-image`,
                    body,
                    config
                )
                .then(function (response) {
                    console.log("response", response);
                    $this.$bvModal.hide("bv-modal-confirm-update-image");
                    $this.$bvModal.hide("bv-modal-add-tag");
                    $this.getAllAccount();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
    },
};
</script>

<style>
.hide {
    display: none;
}

.myDIV:hover + .hide {
    display: block;
    color: red;
}

.event-thumbnail {
    width: 30%;
    height: 30%;
}
</style>
