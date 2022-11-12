<template>
    <div class="container">
        <div>
            <!-- <b-form v-if="true"> -->
            <!-- Image. -->
            <b-row class="text-center">
                <b-col cols="3"> Logo</b-col>
                <b-col cols="6">
                    <!-- <span @click="showPopularPost()">Top</span> | -->
                    <!-- <span @click="showLatestPost()"> Lastest</span> -->
                </b-col>
                <b-col cols="3"> Search Panel</b-col>
            </b-row>
            <b-row class="text-center">
                <b-col cols="3">
                    <!-- Header -->
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
                            <b-avatar class="mr-3"></b-avatar>
                            <span class="mr-auto">{{ account.name }} </span>
                            <small>{{ account.count }} Posts</small>
                        </b-list-group-item>
                    </b-list-group>
                </b-col>
                <b-col cols="6">
                    <!-- Post detail -->
                    <b-row class="m-3 p-3" style="background-color: #f8f9fa">
                        <b-col cols="12 text-left">
                            <div class="text-right">
                                <span>1 ชม.</span>
                                <b-icon icon="share-fill"></b-icon>
                            </div>
                            <!-- post Header -->
                            <h6>{{ postDetail.detail }}</h6>
                            <!-- post account -->
                            <div>
                                <b-badge v-for="postAccount in postDetail.accounts"> {{postAccount.name}} </b-badge>
                            </div>
                            <!-- post url -->
                            <div>
                                <a :href="postDetail.url">{{
                                    postDetail.url
                                }}</a>
                            </div>
                            <!-- post hashtag -->
                            <div>
                                <span>{{ postDetail.hashtags }}</span>
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
                                            {{
                                                postDetail.siblings.length
                                            }}</span
                                        ></b-col
                                    >
                                    <b-col cols="4 text-left">
                                        <b-icon icon="arrow-clockwise"></b-icon
                                        ><span>
                                            {{ postDetail.retweets }}</span
                                        ></b-col
                                    >
                                    <b-col cols="4 text-left">
                                        <b-icon icon="suit-heart"></b-icon
                                        ><span>
                                            {{ postDetail.favorites }}</span
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
                                        @click="
                                            $bvModal.show('bv-modal-example')
                                        "
                                    ></b-form-input>
                                </b-input-group>
                            </div>
                        </b-col>
                    </b-row>
                    <hr />
                    <b-row
                        class="m-3 p-3"
                        style="background-color: #f8f9fa"
                        v-for="post in postDetail.siblings"
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
                                <b-badge>{{ post.account.name }}</b-badge>
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
                                        <span> x </span></b-col
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
                                        @click="gotoPost(post.id)"
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
                <div class="d-block text-center mt-2">
                    <v-select
                        :options="accounts"
                        v-model="selected"
                        :reduce="(accounts) => accounts.id"
                        multiple
                        label="name"
                        placeholder="tags"
                    ></v-select>
                    {{ selected }}
                </div>
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
            postDetail: {},
            siblingText: "",
        };
    },
    async mounted() {
        await this.getAllAccount();
        await this.getPopularAccount();
        await this.getPopularaHashtag();
        // await this.getPostDetail();

        let path = window.location.pathname.toString();
        console.log("window.location", window.location);
        let postId = path.replace("/post-tag/", "");
        // console.log("postId",postId)
        await this.getPostDetail(postId);
    },
    methods: {
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
                parent_id: this.postDetail.id,
            };
            console.log("body", body);
            var datax = new FormData();
            Object.entries(body).forEach(([key, value]) => {
                datax.append(key, value);
            });
            console.log("datax", datax);
            let $this = this;
            axios
                .post(`/api/post/sibling`, body, config)
                .then(function (response) {
                    console.log("response", response);
                    // $this.getAllAccount();
                    $this.getPopularAccount();
                    $this.getPopularaHashtag();
                    let path = window.location.pathname.toString();
                    let postId = path.replace("/post-tag/", "");
                    // // console.log("postId",postId)
                    $this.getPostDetail(postId);
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
        async getPostDetail(id) {
            console.log("getPostDetail....");
            let $this = this;
            const config = {
                headers: {
                    "Content-type": "application/json",
                },
            };

            await axios
                .get(`/api/post/${id}`, config)
                .then(function (response) {
                    let result = response.data;
                    console.log("result postDetail", result);
                    $this.postDetail = result.data;
                })
                .catch(function (error) {
                    // $this.overlay = false;
                    // $this.dialog = true;
                    console.log(error);
                });
        },
        gotoPost(id) {
            console.log("Post", id);
            window.location.href = `/post-tag/${id}`;
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
