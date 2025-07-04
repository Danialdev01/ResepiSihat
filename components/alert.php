<div class="pt-5 px-3 w-full absolute" style="z-index: 100000 !important;">

    <?php

        if(isset($_SESSION['alert-info']) || isset($_SESSION['alert-error']) || isset($_SESSION['alert-success']) || isset($_SESSION['alert-message'])){

            if((isset($_SESSION['alert-info']) && isset($_SESSION['alert-message'])) && $_SESSION['alert-info'] == true){
                ?>
                    <div id="toast-info" class="flex items-center w-full max-w-xs p-4 mb-4 text-secondary-500 bg-white rounded-lg shadow dark-text-secondary-400 dark-bg-secondary-800" role="alert">
                        
                        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark-bg-green-800 dark-text-green-200">
                            <svg class="w-5 h-5 text-secondary-800 dark-text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.408-5.5a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4a1 1 0 0 0-1-1h-2Z" clip-rule="evenodd"/>
                            </svg>
                            <span class="sr-only">Info icon</span>
                        </div>
                        <div class="ms-3 text-sm font-normal text-black"><?php echo $_SESSION['alert-message']?></div>
                        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-secondary-400 hover:text-secondary-400 rounded-lg focus:ring-2 focus:ring-secondary-300 p-1.5 hover:bg-secondary-100 inline-flex items-center justify-center h-8 w-8 dark-text-secondary-500 dark-hover:text-white dark-bg-secondary-800 dark-hover:bg-secondary-700" data-dismiss-target="#toast-info" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                <?php
            }
    
            if((isset($_SESSION['alert-error']) && isset($_SESSION['alert-message'])) && $_SESSION['alert-error'] == true){
                ?>
                    <div id="toast-danger" class="flex items-center w-full max-w-xs p-4 mb-4 text-secondary-500 bg-white rounded-lg shadow dark-text-secondary-400 dark-bg-secondary-800" role="alert">
                        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark-bg-red-800 dark-text-red-200">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                            </svg>
                            <span class="sr-only">Error icon</span>
                        </div>
                        <div class="ms-3 text-sm font-normal"><?php echo $_SESSION['alert-message']?></div>
                        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-secondary-400 hover:text-secondary-900 rounded-lg focus:ring-2 focus:ring-secondary-300 p-1.5 hover:bg-secondary-100 inline-flex items-center justify-center h-8 w-8 dark-text-secondary-500 dark-hover:text-white dark-bg-secondary-800 dark-hover:bg-secondary-700" data-dismiss-target="#toast-danger" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                <?php
            }
    
            if((isset($_SESSION['alert-success']) && isset($_SESSION['alert-message'])) && $_SESSION['alert-success'] == true){
                ?>
                    <div id="toast-success" class="flex items-center w-full max-w-xs p-4 mb-4 text-secondary-500 bg-white rounded-lg shadow dark-text-secondary-400 dark-bg-secondary-800" role="alert">
                        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark-bg-green-800 dark-text-green-200">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                            </svg>
                            <span class="sr-only">Check icon</span>
                        </div>
                        <div class="ms-3 text-sm font-normal"><?php echo $_SESSION['alert-message']?></div>
                        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-secondary-400 hover:text-secondary-900 rounded-lg focus:ring-2 focus:ring-secondary-300 p-1.5 hover:bg-secondary-100 inline-flex items-center justify-center h-8 w-8 dark-text-secondary-500 dark-hover:text-white dark-bg-secondary-800 dark-hover:bg-secondary-700" data-dismiss-target="#toast-success" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                <?php
            }
    
            $_SESSION['alert-message'] = NULL;
            $_SESSION['alert-error'] = NULL;
            $_SESSION['alert-success'] = NULL;
            $_SESSION['alert-info'] = NULL;
        }


    ?>

</div>