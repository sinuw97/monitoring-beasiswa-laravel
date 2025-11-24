<div id="globalConfirmationModal" class="fixed inset-0 z-[60] bg-gray-900/50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-lg shadow-xl max-w-sm w-full m-4 overflow-hidden transform transition-all">
        <div class="p-6">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 text-center" id="confirmationTitle">Konfirmasi Aksi
            </h3>
            <div class="mt-2">
                <p class="text-sm text-gray-500 text-center" id="confirmationMessage">
                    Apakah Anda yakin ingin melakukan aksi ini?
                </p>
            </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
            <button type="button" onclick="confirmAction()"
                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                Ya, Lanjutkan
            </button>
            <button type="button" onclick="closeConfirmationModal()"
                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                Batal
            </button>
        </div>
    </div>
</div>
