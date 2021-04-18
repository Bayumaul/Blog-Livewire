<div class="container mx-auto mt-2">
    <x-jet-banner />
    <div class="flex content-center m-2 p-2">
        <x-jet-button class="bg-green-500" wire:click="showCreatePostsModal">
            Create Post
        </x-jet-button>
    </div>
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 dark:bg-gray-600 dark:text-gray-200">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                Id</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                Title</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                Status</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                Image</th>
                            <th scope="col" class="relative px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr></tr>
                        @foreach ($posts as $post)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $post->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $post->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($post->active)
                                Active
                                @else
                                Not Active
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img class="h-8 w-8 rounded-full" src="{{ asset('/storage/photos/' .$post->image) }}" />
                            </td>
                            <td class="px-6 py-4 text-center text-sm">
                                <button wire:click="showEditPostModal({{ $post->id }})"
                                    class="inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-white uppercase transition bg-green-500 rounded-full shadow ripple hover:shadow-lg hover:bg-green-600 focus:outline-none">
                                    Edit
                                </button>
                                <button wire:click="deletePost({{ $post->id }})"
                                    class="inline-block px-6 py-2 text-xs font-medium leading-6 text-center text-white uppercase transition bg-red-500 rounded-full shadow ripple hover:shadow-lg hover:bg-red-600 focus:outline-none">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach

                        <!-- More items... -->
                    </tbody>
                </table>
                <div class="m-2 p-2">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
    <x-jet-dialog-modal wire:model="showModalForm">
        <x-slot name="title">Create Posts</x-slot>
        <x-slot name="content">
            <div class="space-y-8 divide-y divide-gray-200 mt-10">
                <form enctype="multipart/form-data">
                    <div class="sm:col-span-6">
                        <label for="title" class="block text-sm font-medium text-gray-700"> Post Title </label>
                        <div class="mt-1">
                            <input type="text" id="title" wire:model.lazy="title" name="title"
                                class="block w-full transition duration-150 ease-in-out appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                        </div>
                    </div>
                    <div class="sm:col-span-6">
                        <div class="w-full m-2 p-2">
                            @if ($newImage)
                            Photo :
                            <img src="{{ asset('storage/photos/'. $newImage )}}">
                            @endif
                            @if ($image)
                            Photo Preview :
                            <img src="{{ $image->temporaryUrl() }}">
                            @endif
                        </div>
                        <label for="title" class="block text-sm font-medium text-gray-700"> Post Image </label>
                        <div class="mt-1">
                            <input type="file" id="image" wire:model="image" name="image"
                                class="block w-full transition duration-150 ease-in-out appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                        </div>
                    </div>
                    <div class="sm:col-span-6 pt-5">
                        <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                        <div class="mt-1">
                            <textarea id="body" rows="3" wire:model.lazy="body"
                                class="shadow-sm focus:ring-indigo-500 appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div>
                @if ($postId)
                <x-jet-button wire:click="updatePost">Update</x-jet-button>
                @else
                <x-jet-button wire:click="storePost">Create Post</x-jet-button>
                @endif
            </div>
        </x-slot>
    </x-jet-dialog-modal>
</div>