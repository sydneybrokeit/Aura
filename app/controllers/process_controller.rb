class ProcessController < ApplicationController
  def submit
    sku = Sku.new
    sku.json = params
    sku.save
    require 'aura-print'
    AuraPrint.barcodeWeb(sku)
  end
end
