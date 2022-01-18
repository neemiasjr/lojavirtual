 <hr>

 {if $PRO_TOTAL < 1}
   <H4 class="alert alert-danger">Nenhum produto encontrado!!</H4>
   <meta http-equiv="refresh" content=1;url="{$PRODUTOS}">

 {/if}




 <!--  começa lista de produtos  ---->
 <section id="produtos" class="row">

   <ul style="list-style: none">



     <div class="row" id="pularliha">
       {foreach from=$PRO item=P}

         <li class="col-md-4">

           <div class="thumbnail">
             {if ($P.pro_ativo == 1 && $P.pro_estoque >= 1) }
               <a href="{$PRO_INFO}/{$P.pro_id}/{$P.pro_slug}">

                 <img src="{$P.pro_img}" width="200" height="200" alt="">

                 <div class="caption">

                   <h4 class="text-center"> {$P.pro_nome}</h4>

                   <h3 class="text-center text-danger">{$P.pro_valor}</h3>

                 </div>

               </a>
             {elseif $P.pro_ativo == 0}
             
               <div class="imagem-disabled">
                 <img src="{$P.pro_img}" width="200" height="200" alt="">

                 <div class="caption">

                   <h4 class="text-center">{$P.pro_nome}</h4>

                   <h3 class="text-center text-danger"><s>{$P.pro_valor}</s></h3>

                   <h3 class="text-center alert alert-danger">Indisponível</h3>
                 </div>
               </div>
             {else}
              <div class="imagem-disabled">
                <img src="{$P.pro_img}" width="200" height="200" alt="">

                <div class="caption">

                  <h4 class="text-center"><s>{$P.pro_nome}</s></h4>

                  <h3 class="alert alert-info">Sem estoque</h3>
                </div>
              </div>
             {/if}




           </div>


         </li>

       {/foreach}

     </div>


   </ul>

 </section>


 <!--  paginação inferior   -->
 <section id="pagincao" class="row">
   <center>
     {$PAGINAS}
   </center>
 </section>

 <style>
   div.imagem-disabled {
     opacity: 0.4;
   }
</style>