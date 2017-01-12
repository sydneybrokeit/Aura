class ResultController < ApplicationController
  def load
    @data = getData(params["sku"])
  end
  def getData(mainSku)
    if mainSku != nil
      if @sku = Sku.find_by_sku(mainSku)
        return JSON.parse(@sku.json)
      else
        return "Sorry, that SKU could not be found " + mainSku + sku.json
      end
    end
  end
end
