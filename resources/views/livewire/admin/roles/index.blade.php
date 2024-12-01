<div>
   <div class="py-12">
      <!-- Breadcrump -->
      <div class="max-w-7xl mx-auto space-y-4 sm:px-6 lg:px-8">
         <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
               <li class="inline-flex items-center">
                  <a href="{{ route('admin.roles') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                     Roles
                  </a>
               </li>
               <li>
                  <div class="flex items-center">
                     <x-icons.chevron-right-icon class="w-5 h-5 text-gray-400 mx-1" />
                     <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2">List</a>
                  </div>
               </li>
            </ol>
         </nav>
         <!-- Title -->
         <div class="flex flex-row justify-between items-center">
            <h1 class="uppercase text-2xl font-bold text-yellow-700 text-start">Roles</h1>
            <a wire:navigate href="{{ route('admin.roles.create') }}">
               <x-secondary-button class="bg-lime-900 text-white flex flex-row space-x-0.5">
                  <x-icons.plus-icon class="w-5 h-5" />
                  <span>Add Role</span>
               </x-secondary-button>
            </a>
         </div>

         <!-- Table -->
         <div class="bg-whiterelative shadow-md sm:rounded-lg overflow-hidden">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
               <div class="w-full md:w-1/2">
                  <form class="flex items-center">
                     <label for="simple-search" class="sr-only">Search</label>
                     <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                           <x-icons.magnifying-glass-icon />
                        </div>
                        <input wire:model.live.debounce.500ms="search" type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2" placeholder="Search" required="">
                     </div>
                  </form>
               </div>
               <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                  <div class="flex items-center space-x-3 w-full md:w-auto">
                     <div x-data="{ open: false }" class="relative">
                        <x-secondary-button
                           @click="open = !open"
                           class="flex flex-row space-x-0.5"
                           type="button">
                           <x-icons.funnel-icon class="w-5 h-5 mr-2 text-gray-400" />
                           <span>Filter</span>
                        </x-secondary-button>
                        <div
                           x-show="open"
                           @click.outside="open = false"
                           x-transition:enter="transition ease-out duration-200"
                           x-transition:enter-start="opacity-0 scale-95"
                           x-transition:enter-end="opacity-100 scale-100"
                           x-transition:leave="transition ease-in duration-75"
                           x-transition:leave-start="opacity-100 scale-100"
                           x-transition:leave-end="opacity-0 scale-95"
                           class="absolute right-0 z-10 mt-2 w-72 p-3 bg-white rounded-lg shadow">
                           <h6 class="mb-3 text-sm font-medium text-gray-900">Choose brand</h6>
                           <ul class="space-y-2 text-sm"></ul>
                           <li class="flex items-center">
                              <input id="apple" type="checkbox" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500">
                              <label for="apple" class="ml-2 text-sm font-medium text-gray-900 break-normal">Apple wdadaw dadwa adawdaw (56)</label>
                           </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="overflow-x-auto">
               <table class="w-full text-sm text-left text-gray-500">
                  <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                     <tr>
                        <th scope="col" class="px-4 py-3 whitespace-nowrap">Name</th>
                        <th scope="col" class="px-4 py-3 whitespace-nowrap">Permissions</th>
                        <th scope="col" class="px-4 py-3 w-20">
                           <span class="sr-only">Actions</span>
                        </th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($roles as $role)
                     <tr wire:key="{{ $role->id }}" class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $role->name }}</td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $role->permissions->count() ?? 0 }}</td>
                        <td class="px-4 py-3">
                           <div x-data="{ open: false }" class="relative flex justify-end">
                              <button
                                 @click="open = !open"
                                 class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none">
                                 <x-icons.ellipsis-vertical-icon />
                              </button>
                              <div
                                 x-show="open"
                                 @click.outside="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute z-10 w-44 right-10 bg-white rounded divide-y divide-gray-100 shadow">
                                 <ul class="py-1 text-sm text-gray-700">
                                    <li>
                                       <a href="{{ route('admin.roles.edit', $role->id) }}"
                                          class="block py-2 px-4 hover:bg-gray-100"
                                          wire:navigate>
                                          Edit
                                       </a>
                                    </li>
                                 </ul>
                                 <div class="py-1">
                                    <button
                                       @click="$dispatch('open-modal', 'delete-role-{{ $role->id }}')"
                                       class="block w-full text-left py-2 px-4 text-sm text-gray-700 hover:bg-gray-100">
                                       Delete
                                    </button>
                                 </div>
                              </div>
                           </div>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
            <nav class="p-4">
               {{ $roles->links() }}
            </nav>
         </div>
         <!-- End of Table -->
      </div>
   </div>
</div>