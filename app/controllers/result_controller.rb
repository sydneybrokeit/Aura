class ResultController < ApplicationController
    def load
        @data = getData(params['sku'])
    end

    def getData(mainSku)
        if @sku = Sku.find_by_sku(mainSku)
            JSON.parse(@sku.json)
        else
            Sku.find_by_sku(mainSku)
            @error = 'Sorry, that SKU could not be found'
        end
    end
end
