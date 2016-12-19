class ResultController < ApplicationController
  def load
    @data = getData(params["sku"])
    render text: params["sku"]  
  end
  def getData(mainSku)
    Sku.all.each do |sku|
      if JSON.parse(sku.json)["sku"] == mainSku
        return JSON.parse(sku.json)
      else
        return "Sorry, that SKU could not be found " + mainSku + sku.json
    end
  end
end
end
